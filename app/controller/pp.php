<?php

class PPController extends Controller {

	public function defaultAction() {
		$data = DB::query("SELECT * FROM pp WHERE;");

		$this->view->render('pp-list', array('data' => $data));
	}

	public function createAction() {
		if (!empty($_POST['presentation-name'])) {
			$sql = DB::query("INSERT INTO pp (name) VALUES('" . DB::protect($_POST['presentation-name']) . "');");
			Core::request()->redirect('pp/edit', array('id' => DB::lastId()));
		}

		$this->view->render('pp-create');
	}

	public function editAction() {
		$id = (int) $this->request->getParam('id');

		$result = DB::query("SELECT * FROM pp WHERE id = $id;");
		$data = $result->get(0);

		$slajdy = DB::query("SELECT * FROM slides WHERE pp_id = $id ORDER BY id ASC;");

		$this->view->render('pp-edit', array('data' => $data, 'slajdy' => $slajdy));
	}

	public function slideAction() {
		$id = (int) $this->request->getParam('id');

		DB::query("INSERT INTO slides (pp_id) VALUES ($id);");

		$result = DB::query("SELECT * FROM slides WHERE pp_id = $id ORDER BY id ASC;");

		if ($this->request->isAjax()) {
			$this->ajax = TRUE;
			$this->view->ajaxRender('pp-left-slide', array('slajdy' => $result, 'id' => $id));
		} else {
			$this->request->redirect('pp/edit', array('id' => $id));
		}
	}

	public function delslideAction() {
		$id = (int) $this->request->getParam('id');
		$slid = (int) $this->request->getParam('slid');

		DB::query("DELETE FROM slides WHERE id = $slid;");

		if ($this->request->isAjax()) {
			$result = DB::query("SELECT * FROM slides WHERE pp_id = $id ORDER BY id ASC;");
			$this->ajax = TRUE;
			$this->view->ajaxRender('pp-left-slide', array('slajdy' => $result, 'id' => $id));
		} else {
			$this->request->redirect('pp/edit', array('id' => $id));
		}
	}

}
