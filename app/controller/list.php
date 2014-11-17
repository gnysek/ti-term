<?php

class ListController extends Controller {

	public function defaultAction() {
		$result = DB::query("SELECT * FROM pp LEFT JOIN remote on remote.remote_pp = pp.id ORDER BY id ASC;");
		$this->view->render('list', array('pp' => $result, 'uid' => $this->session->userId));
	}

}
