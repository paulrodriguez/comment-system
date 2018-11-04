<?php
namespace Controller;
class IndexController extends BaseController {

	/**
	 * home page
	 */
	public function indexAction() {
		$block = new \Model\Block();
		$block->render('index');
	}

	/**
	 * action to save a comment to persistent storage
	 * TODO: move validation to model
	 */
	public function addCommentAction() {

		$res = array('success'=>true);
		$content = '';
		$author = '';
		$parent_id = 0;
		$level = 0;

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			$res['success'] = false;
			$res['error'] = 'Invalid Request';

			header('Content-type: application/json');
			echo json_encode($res);
			return;
		}

		// validate content field is present
		if(isset($_POST['content'])) {
			$content = strip_tags($_POST['content']);
		} else {
			$res['success'] = false;
			$res['error'] = 'content cannot be empty.';
		}

		// validate author field is present
		if(isset($_POST['author'])) {
			$author = strip_tags($_POST['author']);
		} else {
			$res['success'] = false;
			$res['error'] = 'author cannot be empty.';
		}

		// validate parent id is integer
		if(isset($_POST['parent_id'])) {
			$tmp = filter_var($_POST['parent_id'] ,FILTER_VALIDATE_INT);
			if($tmp!==false) {
				$parent_id = $tmp;
			} else {
				$res['success'] = false;
				$res['error'] = 'invalid sub comment';
			}
		}

		// validate level is between 0 and 2 inclusive
		if(isset($_POST['level'])) {
			$tmp = filter_var($_POST['level'],FILTER_VALIDATE_INT);
			if($tmp < 3 and $tmp >=0) {
				$level = $tmp;
			} else {
				$res['success'] = false;
				$res['error'] = 'Invalid comment for hierarchy level';
			}
		}

		// validate content field is not empty and less than 500 chars
		if($content=='') {
			$res['success'] = false;
			$res['error'] = 'content cannot be empty';
		} else if(strlen($content)>500) {
			$res['success'] = false;
			$res['error'] = 'content limit is 500 characters.';
		}

		// validate author field is not empty and less than 100 chars
		if($author == '') {
			$res['success'] = false;
			$res['error'] = 'author cannot be empt';
		} else if(strlen($author) > 100) {
			$res['success'] = false;
			$res['error'] = 'author limit is 100 characters.';
		}

		// output error
		if($res['success'] == false) {
			header('Content-type: application/json');
			echo json_encode($res);
			return;
		}

		// set fields to model
		$comment = new \Model\Comment();
		$comment->setData('content',$content);
		$comment->setData('author',$author);
		$comment->setData('parent_id',$parent_id);
		$comment->setData('level',$level);

		if($comment->save()) {
			$res['success'] = true;
			$res['message'] = 'Comment sucessfully added';
			$res['comment'] = $comment->getData();
		} else {
			$res['success'] = false;
			$res['message'] = 'there was an error saving your comment';
		}

		header('Content-type: application/json');
		echo json_encode($res);



	}

	/**
	 * load all comments in persistent storage
	 */
	public function getAllCommentsAction() {
		header('Content-type: application/json');

		$comment = new \Model\Comment();

		$res = $comment->getAllByOrder();

		echo json_encode($res);

	}
}
