<?php

class PPController extends Controller {

	public function defaultAction() {
		$data = DB::query("SELECT * FROM pp;");

		$this->view->render('pp-list', array('data' => $data, 'uid' => $this->session->userId));
	}
	
	public function themeAction() {
		if (!$this->session->logged) {
			$this->accessDenied();
		}
		
		$id = (int) $this->request->getParam('id');
		
		$this->view->render('pp-theme', array('id' => $id));
	}
	
	public function savethemeAction(){
		$id = (int) $this->request->getParam('id');
		$theme = (int) $this->request->getParam('theme');
		
		DB::update("UPDATE pp SET theme = $theme WHERE id = $id;");
		
		$this->request->redirect('list');
	}

	public function createAction() {
		if (!$this->session->logged) {
			$this->accessDenied();
		}

		if (!empty($_POST['presentation-name'])) {
			$sql = DB::query("INSERT INTO pp (name) VALUES('" . DB::protect($_POST['presentation-name']) . "');");
			Core::request()->redirect('pp/edit', array('id' => DB::lastId()));
		}

		$this->view->render('pp-create');
	}

	public function editAction() {
		if (!$this->session->logged) {
			$this->accessDenied();
		}

		$id = (int) $this->request->getParam('id');
		$slid = (int) $this->request->getParam('slid');
		
		$result = DB::query("SELECT * FROM pp WHERE id = $id;");
		$data = $result->get(0);

		$slajdy = DB::query("SELECT * FROM slides WHERE pp_id = $id ORDER BY id ASC;");

		$this->view->addJs('media/jquery.cleditor.js');
		$this->view->addJs('media/jquery.cleditor.bbcode.js');
		$this->view->addCss('media/jquery.cleditor.css');
		$this->view->render('pp-edit', array('data' => $data, 'slajdy' => $slajdy, 'slajdObecny' => $slid));
	}

	public function addslideAction() {
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
		if (!$this->session->logged) {
			$this->accessDenied();
		}

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

	public function editslideAction() {
		$id = (int) $this->request->getParam('id');
		$slid = (int) $this->request->getParam('slid');
		if ($this->request->isAjax()) {
			$result = DB::query("SELECT * FROM slides WHERE pp_id = $slid ORDER BY id ASC;");
			$this->ajax = TRUE;
			$this->view->ajaxRender('pp-textarea', array('obecny' => $result->get(0)));
		} else {
			$this->request->redirect('pp/edit', array('id' => $id, 'slid' => $slid));
		}
	}

	public function saveslideAction() {
		if (!$this->session->logged) {
			$this->accessDenied();
		}

		$id = (int) $this->request->getParam('id');

		if ($id > 0 && !empty($_POST['slideData'])) {
			//sprawdź autora
			$sql = new Sql();
			$result = $sql->from('slides')
				->where('id = ?', $id)
				->load();

			if ($sql->size()) {
				$r = $result->get(0);
//				if ($r->user == $this->session->userId) {
				$sql = new Sql();
				$sql->update('slides')
					->where('id = ?', $id)
					->columns(array('text', 'last_time'))
					->values(array($_POST['slideData']['text'], time()))
					->execute();

				$this->request->redirect('pp/edit', array('id' => $r->pp_id, 'slid' => $r->id));
//				}
			}
		}

		//def
		$this->request->redirect('list');
	}

}
