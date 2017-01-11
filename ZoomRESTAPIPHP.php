<?php
/*Zoom Video Communications, Inc. 2015*/
/*Zoom Support*/

class ZoomAPI{

	/*The API Key, Secret, & URL will be used in every function.*/
	private $api_key = 'Please Input Your Own API Key Here';
	private $api_secret = 'Please Input Your Own API Secret Here';
	private $api_url = 'https://api.zoom.us/v1/';

	/*Function to send HTTP POST Requests*/
	/*Used by every function below to make HTTP POST call*/
	function sendRequest($calledFunction, $data){
		/*Creates the endpoint URL*/
		$request_url = $this->api_url.$calledFunction;

		/*Adds the Key, Secret, & Datatype to the passed array*/
		$data['api_key'] = $this->api_key;
		$data['api_secret'] = $this->api_secret;
		$data['data_type'] = 'JSON';

		$postFields = http_build_query($data);
		/*Check to see queried fields*/
		/*Used for troubleshooting/debugging*/
		echo $postFields;

		/*Preparing Query...*/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		$response = curl_exec($ch);

		/*Check for any errors*/
		$errorMessage = curl_exec($ch);
		echo $errorMessage;
		curl_clost($ch);

		/*Will print back the response from the call*/
		/*Used for troubleshooting/debugging		*/
		echo $request_url;
		var_dump($data);
		var_dump($response);
		if(!$response){
			return false;
		}
		/*Return the data in JSON format*/
		return json_encode($response);
	}
	/*Functions for management of users*/

	function createAUser(){		
		$createAUserArray = array();
		$createAUserArray['email'] = $_POST['userEmail'];
		$createAUserArray['type'] = $_POST['userType'];
		return $this->sendRequest('user/create', $createAUserArray);
	}   

	function autoCreateAUser(){
	  $autoCreateAUserArray = array();
	  $autoCreateAUserArray['email'] = $_POST['userEmail'];
	  $autoCreateAUserArray['type'] = $_POST['userType'];
	  $autoCreateAUserArray['password'] = $_POST['userPassword'];
	  return $this->sendRequest('user/autocreate', $autoCreateAUserArray);
	}

	function custCreateAUser(){
	  $custCreateAUserArray = array();
	  $custCreateAUserArray['email'] = $_POST['userEmail'];
	  $custCreateAUserArray['type'] = $_POST['userType'];
	  return $this->sendRequest('user/custcreate', $custCreateAUserArray);
	}  

	function deleteAUser(){
	  $deleteAUserArray = array();
	  $deleteAUserArray['id'] = $_POST['userId'];
	  return $this->sendRequest('user/delete', $deleteUserArray);
	}     

	function listUsers(){
	  $listUsersArray = array();
	  return $this->sendRequest('user/list', $listUsersArray);
	}   

	function listPendingUsers(){
	  $listPendingUsersArray = array();
	  return $this->sendRequest('user/pending', $listPendingUsersArray);
	}    

	function getUserInfo(){
	  $getUserInfoArray = array();
	  $getUserInfoArray['id'] = $_POST['userId'];
	  return $this->sendRequest('user/get',$getUserInfoArray);
	}   

	function getUserInfoByEmail(){
	  $getUserInfoByEmailArray = array();
	  $getUserInfoByEmailArray['email'] = $_POST['userEmail'];
	  $getUserInfoByEmailArray['login_type'] = $_POST['userLoginType'];
	  return $this->sendRequest('user/getbyemail',$getUserInfoByEmailArray);
	}  

	function updateUserInfo(){
	  $updateUserInfoArray = array();
	  $updateUserInfoArray['id'] = $_POST['userId'];
	  return $this->sendRequest('user/update',$updateUserInfoArray);
	}  

	function updateUserPassword(){
	  $updateUserPasswordArray = array();
	  $updateUserPasswordArray['id'] = $_POST['userId'];
	  $updateUserPasswordArray['password'] = $_POST['userNewPassword'];
	  return $this->sendRequest('user/updatepassword', $updateUserPasswordArray);
	}      

	function setUserAssistant(){
	  $setUserAssistantArray = array();
	  $setUserAssistantArray['id'] = $_POST['userId'];
	  $setUserAssistantArray['host_email'] = $_POST['userEmail'];
	  $setUserAssistantArray['assistant_email'] = $_POST['assistantEmail'];
	  return $this->sendRequest('user/assistant/set', $setUserAssistantArray);
	}     

	function deleteUserAssistant(){
	  $deleteUserAssistantArray = array();
	  $deleteUserAssistantArray['id'] = $_POST['userId'];
	  $deleteUserAssistantArray['host_email'] = $_POST['userEmail'];
	  $deleteUserAssistantArray['assistant_email'] = $_POST['assistantEmail'];
	  return $this->sendRequest('user/assistant/delete',$deleteUserAssistantArray);
	}   

	function revokeSSOToken(){
	  $revokeSSOTokenArray = array();
	  $revokeSSOTokenArray['id'] = $_POST['userId'];
	  $revokeSSOTokenArray['email'] = $_POST['userEmail'];
	  return $this->sendRequest('user/revoketoken', $revokeSSOTokenArray);
	}      

	function deleteUserPermanently(){
	  $deleteUserPermanentlyArray = array();
	  $deleteUserPermanentlyArray['id'] = $_POST['userId'];
	  $deleteUserPermanentlyArray['email'] = $_POST['userEmail'];
	  return $this->sendRequest('user/permanentdelete', $deleteUserPermanentlyArray);
	}               

	/*Functions for management of meetings*/
	function createAMeeting(){
	  $createAMeetingArray = array();
	  $createAMeetingArray['host_id'] = $_POST['userId'];
	  $createAMeetingArray['topic'] = $_POST['meetingTopic'];
	  $createAMeetingArray['type'] = $_POST['meetingType'];
	  return $this->sendRequest('meeting/create', $createAMeetingArray);
	}

	function deleteAMeeting(){
	  $deleteAMeetingArray = array();
	  $deleteAMeetingArray['id'] = $_POST['meetingId'];
	  $deleteAMeetingArray['host_id'] = $_POST['userId'];
	  return $this->sendRequest('meeting/delete', $deleteAMeetingArray);
	}

	function listMeetings(){
	  $listMeetingsArray = array();
	  $listMeetingsArray['host_id'] = $_POST['userId'];
	  return $this->sendRequest('meeting/list',$listMeetingsArray);
	}

	function getMeetingInfo(){
      $getMeetingInfoArray = array();
	  $getMeetingInfoArray['id'] = $_POST['meetingId'];
	  $getMeetingInfoArray['host_id'] = $_POST['userId'];
	  return $this->sendRequest('meeting/get', $getMeetingInfoArray);
	}

	function updateMeetingInfo(){
	  $updateMeetingInfoArray = array();
	  $updateMeetingInfoArray['id'] = $_POST['meetingId'];
	  $updateMeetingInfoArray['host_id'] = $_POST['userId'];
	  return $this->sendRequest('meeting/update', $updateMeetingInfoArray);
	}

	function endAMeeting(){
      $endAMeetingArray = array();
	  $endAMeetingArray['id'] = $_POST['meetingId'];
	  $endAMeetingArray['host_id'] = $_POST['userId'];
	  return $this->sendRequest('meeting/end', $endAMeetingArray);
	}

	function listRecording(){
      $listRecordingArray = array();
	  $listRecordingArray['host_id'] = $_POST['userId'];
	  return $this->sendRequest('recording/list', $listRecordingArray);
	}


	/*Functions for management of reports*/
	function getDailyReport(){
	  $getDailyReportArray = array();
	  $getDailyReportArray['year'] = $_POST['year'];
	  $getDailyReportArray['month'] = $_POST['month'];
	  return $this->sendRequest('report/getdailyreport', $getDailyReportArray);
	}

	function getAccountReport(){
	  $getAccountReportArray = array();
	  $getAccountReportArray['from'] = $_POST['from'];
	  $getAccountReportArray['to'] = $_POST['to'];
	  return $this->sendRequest('report/getaccountreport', $getAccountReportArray);
	}

	function getUserReport(){
	  $getUserReportArray = array();
	  $getUserReportArray['user_id'] = $_POST['userId'];
	  $getUserReportArray['from'] = $_POST['from'];
	  $getUserReportArray['to'] = $_POST['to'];
	  return $this->sendRequest('report/getuserreport', $getUserReportArray);
	}


	/*Functions for management of webinars*/
	function createAWebinar(){
	  $createAWebinarArray = array();
	  $createAWebinarArray['host_id'] = $_POST['userId'];
	  $createAWebinarArray['topic'] = $_POST['topic'];
	  return $this->sendRequest('webinar/create',$createAWebinarArray);
	}

	function deleteAWebinar(){
	  $deleteAWebinarArray = array();
	  $deleteAWebinarArray['id'] = $_POST['webinarId'];
	  $deleteAWebinarArray['host_id'] = $_POST['userId'];
	  return $this->sendRequest('webinar/delete',$deleteAWebinarArray);
	}

	function listWebinars(){
	  $listWebinarsArray = array();
	  $listWebinarsArray['host_id'] = $_POST['userId'];
	  return $this->sendRequest('webinar/list',$listWebinarsArray);
	}

	function getWebinarInfo(){
	  $getWebinarInfoArray = array();
	  $getWebinarInfoArray['id'] = $_POST['webinarId'];
	  $getWebinarInfoArray['host_id'] = $_POST['userId'];
	  return $this->sendRequest('webinar/get',$getWebinarInfoArray);
	}

	function updateWebinarInfo(){
	  $updateWebinarInfoArray = array();
	  $updateWebinarInfoArray['id'] = $_POST['webinarId'];
	  $updateWebinarInfoArray['host_id'] = $_POST['userId'];
	  return $this->sendRequest('webinar/update',$updateWebinarInfoArray);
	}

	function endAWebinar(){
	  $endAWebinarArray = array();
	  $endAWebinarArray['id'] = $_POST['webinarId'];
	  $endAWebinarArray['host_id'] = $_POST['userId'];
	  return $this->sendRequest('webinar/end',$endAWebinarArray);
	}
}

?> 