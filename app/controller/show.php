<?php

class ShowController extends Controller {

	public function viewppAction() {
		$id = (int) $this->request->getParam('id');
		/* @var $result Collection */
		$result = DB::sql()->from('pp')->where('id = ? ', $id)->load();
		
		$theme = $result->get(0)->theme;
		if (!empty($theme)) {
			$theme = 'bg' . $theme;
		}

		$result = DB::sql()->from('slides')->where('pp_id = ? ', $id)->load();
		$this->view->render('show-view',array('slides'=>$result, 'theme'=>$theme));
	}

}
