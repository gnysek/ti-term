<?php

class ListController extends Controller {

	public function defaultAction() {
		$result = DB::query("SELECT * FROM pp ORDER BY id ASC;");
		$this->view->render('list', array('pp' => $result));
	}

}
