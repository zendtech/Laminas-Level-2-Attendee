<?php
/**
 * IndexController
 */
namespace src\modOtherComponents\CrossCuttingConcerns;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class PostController extends AbstractActionController
{
    public function submitAction() {
        // tangling code start
        $user = $this->serviceLocator->get('user');
        if (!$user->isLoggedIn()) {
                // the user has to be logged in to execute this action
                return $this->redirect()->toRoute('login');
        }
        // tangling code end

        // ...
        if ($form->isValid($postData)) {
                $this->serviceLocator->get('postManager')->save($postData);
            return $this->redirect()->toRoute( 'market/post',
                    [
                        'action' => 'view',
                    'id' => $id
                ]
            );
        }
        // ...
    }

    public function listCategoryAction() {
        // tangling code, part 1 - start
        $cacheKey = 'CATEGORY_' . $this->params('cid');
        $cacheService = $this->serviceLocator->get('cache');
        if ($data = $cacheService->getItem($cacheKey)) return new ViewModel(['data' => $data]);
        // tangling code, part 1 - end

        // aspect code - start
        $postModel = new PostModel();
        $posts = $postModel->getCategoryList($this->param('cid'));
        $data = ['posts' => $posts];
        // aspect - end

        // tangling code, part 2 start
        $cacheService->setItem($cacheKey, $data);
        // tangling code, part 2 end

        // ...
    }
}