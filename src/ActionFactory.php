<?php
namespace Cadre\CliAdr;

use Arbiter\ActionFactory as ArbiterFactory;
use Aura\Cli\Context;

class ActionFactory extends ArbiterFactory
{
    /**
     * Routing Failed Responder
     *
     * @var mixed
     *
     * @access protected
     */
    protected $failResponder;

    /**
     * Context to Route matcher
     *
     * @var Router\Matcher
     *
     * @access protected
     */
    protected $matcher;

    /**
     * __construct
     *
     * @param Router\Matcher $matcher       Matched route based on context
     * @param mixed          $failResponder responder to use when no match
     *
     * @access public
     */
    public function __construct(
        Router\Matcher $matcher,
        $failResponder = Responder\NotFound::class
    ) {
        $this->matcher = $matcher;
        $this->failResponder = $failResponder;
    }

    /**
     * Create Action from Context
     *
     * @param Context $context command context
     *
     * @return \Arbiter\Action
     *
     * @access public
     */
    public function fromContext(Context $context)
    {
        $route  = $this->matcher->match($context);

        return $route
            ? $this->fromRoute($route)
            : $this->failedAction($context);
    }

    /**
     * Create an Action from a Route
     *
     * @param Router\Route $route Route to create action from
     *
     * @return \Arbiter\Action
     *
     * @access protected
     */
    protected function fromRoute(Router\Route $route)
    {
        return $this->newInstance(
            $route->input,
            $route->domain,
            $route->responder
        );
    }

    /**
     * Create an action for failed to match
     *
     * @param Context $context Command context
     *
     * @return \Arbiter\Action
     *
     * @access protected
     */
    protected function failedAction(Context $context)
    {
        $input = function () use ($context) {
            return [$context];
        };

        return $this->newInstance(
            $input,
            [$this->matcher, 'getName'],
            $this->failResponder
        );
    }
}
