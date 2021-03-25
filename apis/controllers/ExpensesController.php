<?php
class ExpensesController extends Controller
{
    public function insertAction()
    {
        // TODO: フロント実実装時にcsrfチェック用処理を作成すること
        return $this->render([
        'getExpensesRepository' => $this->db_manager->get('Expenses'),
        'getData' => $this->getContents()
      ]);
    }

    public function updateAction()
    {
        // TODO: フロント実実装時にcsrfチェック用処理を作成すること
        return $this->render([
        'getExpensesRepository' => $this->db_manager->get('Expenses'),
        'getData' => $this->getContents()
      ]);
    }

    public function deleteAction()
    {
        // TODO: フロント実実装時にcsrfチェック用処理を作成すること
        return $this->render([
        'getExpensesRepository' => $this->db_manager->get('Expenses'),
        'getData' => $this->getContents()
      ]);
    } 

}
