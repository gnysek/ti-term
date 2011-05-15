<?php

class ShowController extends Controller {

	public function viewppAction() {
		$id = (int) $this->request->getParam('id');

		$result = DB::sql()->from('slides')->where('pp_id = ? ', $id)->load();
		$this->view->render('show-view',array('slides'=>$result));
	}

}
