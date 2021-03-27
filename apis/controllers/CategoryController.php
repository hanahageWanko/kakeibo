<?php
class CategoryController extends Controller
{
    public function insertAction()
    {
        // TODO: フロント実実装時にcsrfチェック用処理を作成すること
        return $this->render([
        'getCategoryRepository' => $this->db_manager->get('Category'),
        'getData' => $this->getContents()
      ]);
    }

    public function readAction()
    {
        // TODO: フロント実実装時にcsrfチェック用処理を作成すること
        return $this->render([
        'getCategoryRepository' => $this->db_manager->get('Category'),
      ]);
    }

    public function updateAction()
    {
        // TODO: フロント実実装時にcsrfチェック用処理を作成すること
        return $this->render([
        'getCategoryRepository' => $this->db_manager->get('Category'),
        'getData' => $this->getContents()
      ]);
    }

    public function deleteAction()
    {
        // TODO: フロント実実装時にcsrfチェック用処理を作成すること
        return $this->render([
        'getCategoryRepository' => $this->db_manager->get('Category'),
        'getData' => $this->getContents()
      ]);
    }

}
