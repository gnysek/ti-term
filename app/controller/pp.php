<?php

class PPController extends Controller {

	public function defaultAction() {
		$this->createAction();
	}

	public function createAction() {
		if (!empty($_POST)) {
			$sql = DB::query("INSERT INTO pp VALUES()");
		}
		
		$this->view->render('pp-create');
	}

	public function editAction() {
		$this->view->render('pp-edit');
	}

}
