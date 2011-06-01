<?php

class RemoteController extends Controller {

	public function createAction() {
		$id = (int) $this->request->getParam('id');

		$result = DB::sql()->from('remote')->where('remote_pp = ?', $id)->load();
		if ($result->count() == 0) {
			DB::sql()
				->insert()
				->into('remote')
				->columns(array('remote_pp', 'time', 'current_slide', 'private'))
				->values(array($id, time(), 0, 0))
				->execute();
		}

		$this->request->redirect('remote/manage', array('id' => $id));
	}

	public function manageAction() {
		$id = (int) $this->request->getParam('id');

		$result = DB::sql()->from('remote')->where('remote_pp = ?', $id)->load();

		if ($result->count() == 0) {
			Error::t('Nie ma takiej prezentacji');
		} else {
			$slides = DB::sql()->from('slides')->where('pp_id = ? ', $id)->load();
			$this->view->render('show-view', array('slides' => $slides, 'remote' => 'true', 'startSlide' => $result->get(0)->current_slide));
		}
	}

	public function currentSlideAction() {
		$id = (int) $this->request->getParam('id');
		$slid = (int) $this->request->getParam('slid');

		DB::sql()
			->update('remote')
			->columns(array('time', 'current_slide'))
			->values(array(time(), $slid))
			->where('remote_pp = ?', $id)
			->execute();

		if ($this->request->isAjax()) {
			echo json_encode(array('success' => 1));
		} else {
			Error::t('To nie jest ajax?');
		}
	}

	public function synchroSlideAction() {
		$id = (int) $this->request->getParam('id');

		if ($this->request->isAjax()) {
			$result = DB::sql()->from('remote')->where('remote_pp = ?', $id)->load();
			if ($result->count() == 0) {
				echo json_encode(array('success' => 0));
			} else {
				echo json_encode(array(
						'success' => 1,
						'currSlide' => (int) $result->get(0)->current_slide
				));
			}
		} else {
			Error::t('To nie jest ajax?');
		}
	}

	public function viewAction() {
		$id = (int) $this->request->getParam('id');

		$result = DB::sql()->from('remote')->where('remote_pp = ?', $id)->load();

		if ($result->count() == 0) {
			Error::t('Nie ma takiej prezentacji');
		} else {
			$result = DB::sql()->from('pp')->where('id = ? ', $id)->load();
		
			$theme = $result->get(0)->theme;
			if (!empty($theme)) {
				$theme = 'bg' . $theme;
			}
			
			$result = DB::sql()->from('slides')->where('pp_id = ? ', $id)->load();
			$this->view->render('show-view', array('slides' => $result, 'remoteView' => 'true', 'theme'=>$theme));
		}
	}

}
