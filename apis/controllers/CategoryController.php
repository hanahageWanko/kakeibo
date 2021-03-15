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
}
