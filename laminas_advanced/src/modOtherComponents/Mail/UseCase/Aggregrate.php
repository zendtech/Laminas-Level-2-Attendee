<?php
/**
 * Aggregrate
 */
namespace src\modOtherComponents\Mail\UseCase;
use Laminas\EventManager\ {EventManagerInterface, ListenerAggregateInterface};
use Psr\Container\ContainerInterface;
use Laminas\Mail\Message;
use Laminas\Mime\{Mime, Part, Message as MimeMessage};
use Laminas\View\{Model\ViewModel, Renderer\PhpRenderer, Resolver\AggregateResolver, Resolver\TemplateMapResolver};
class Aggregrate implements ListenerAggregateInterface
{
    protected $listeners;
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
    public function attach(EventManagerInterface $eventManager, $priority = 100) {
        $sharedEventManager = $eventManager->getSharedManager();
        $this->listeners[] = $sharedEventManager->attach(
            '*', NotificationEvent::EVENT_EMAIL_NOTIFICATION, [$this, 'sendEmail']);
    }
    public function detach(EventManagerInterface $eventManager, $priority = 100) {
        // do nothing
    }
    public function sendEmail($e) {
        // Get config from event $e
        $config = $e->getParam('email-notification-config');

        // Set up ViewModel and template for rendering
        $viewModel = new ViewModel();
        $template = array_keys($config['template_map'])[0];
        $viewModel->setTemplate($template);

        // get template map (must contain the template specified above!
        $templateMap = $config['template_map'];

        // render email template
        $phpRenderer = new PhpRenderer();
        $aggregateResolver = new AggregateResolver();
        $aggregateResolver->attach(new TemplateMapResolver($templateMap));
        $phpRenderer->setResolver($aggregateResolver);
        // assign values from params passed by the trigger
        foreach ($config['email-options'] as $key => $value) {
            $viewModel->setVariable($key, $value);
        }

        // Create the HTML body
        $html = new Part($phpRenderer->render($viewModel));
        $html->type = Mime::TYPE_HTML;
        $html->charset = 'utf-8';
        $html->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
        $body = (new MimeMessage())->setParts([$html]);
        $message  = (new Message())
            ->addTo($config['email-options']['to'])
            ->addFrom($config['email-options']['from'])
            ->setSubject($config['email-options']['subject'])
            ->setBody($body)
            ->setEncoding('UTF-8');
        $transport = $this->container->get('email-notification-transport-file');
        NotificationEvent::$success = true;
        $transport->send($message);
    }
}