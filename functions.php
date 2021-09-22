<?php

//VIDEO// YOUTUBE
//https: //www.youtube.com/watch?v=EmIFd4xbWnc


/**
 * FACEBOOK GRAPH API
 */

// syntax for api call endpoint
$endpointSyntax = 'GET https://graph.facebook.com/v12.0/{ig-user-id}/stories';

//DATOS TIRONDOA
//ACCESS TOKEN GENERAL = EAAIvcqoUI48BAHtyi60ua1nn8xWrKVpDqAmzsZAkzsOZBX6rL1Cuzzk42fXZBmuzFOVsRqmhQuYT7936I0EHsWZCN1KrOA7NqUclSCZCTB3DwsxkZCbt6tTB2vnc2lIEYGMNoHcMZAPoA4Fv8UsW5ZC6dOous2KbJjxZA8bqcdmD7XxWc3xG0PqF1gj2QepQuk03rAiUMsuTCc3ScZBbwp1S6x
//FACEBOOK PAGE ID =   139474372901447
//INSTAGRAM BUSSINESS ACOUNT ID = 17841444717919581
//doc: https://developers.facebook.com/docs/instagram-api/getting-started/

/**
 * Get a users stories
 *
 * @param string $instagramAccountId
 * @param string $accessToken
 *
 * @return array with the api response
 */
function getUserStories($instagramAccountId, $accessToken)
{
	// actual endpoint with a media
	$endpoint = 'https://graph.facebook.com/v12.0/' . $instagramAccountId . '/stories';

	$params = array( // parameters for the endpoint
		'access_token' => $accessToken
	);

	// make the api call and get a response
	$response = makeApiCall($endpoint, 'GET', $params);
	//echo_log($response['data']);

	// return data from the response
	return $response['data']['data'];
}

/**
 * Get media info
 *
 * @param array $media
 * @param string $accessToken
 *
 * @return array with the api response
 */
function getMediaInfo($media, $accessToken)
{
	// actual endpoint with a media
	$endpoint = 'https://graph.facebook.com/v12.0/' . $media['id'];

	$params = array( // parameters for the endpoint
		'fields' => 'caption,id,ig_id,media_product_type,media_type,media_url,owner,permalink,shortcode,thumbnail_url,timestamp,username',
		'access_token' => $accessToken
	);

	// make the api call and get a response
	$response = makeApiCall($endpoint, 'GET', $params);

	// return data from the response
	return $response['data'];
}

/**
 * Make a a curl call to an endpoint with params
 *
 * @param string $endpoint we are hitting
 * @param string $type of request
 * @param array $params to send along with the request
 *
 * @return array with the api response
 */
function makeApiCall($endpoint, $type, $params)
{
	// initialize curl
	$ch = curl_init();

	// create endpoint with params
	$apiEndpoint = $endpoint . '?' . http_build_query($params);

	// set other curl options
	curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// get response
	$response = curl_exec($ch);

	// close curl
	curl_close($ch);

	return array( // return data
		'type' => $type,
		'endpoint' => $endpoint,
		'params' => $params,
		'api_endpoint' => $apiEndpoint,
		'data' => json_decode($response, true)
	);
}


/**
 * RENDER LAYOUT
 */

function renderLayout($stories, $user, $token)
{
	//echo_log($user);
	include dirname(__FILE__) . '/templates/layout.php';
}

//DEBUGGING
/* Echo variable
 * Description: Uses <pre> and print_r to display a variable in formated fashion
 */
function echo_log($what)
{
	echo '<pre>' . print_r($what, true) . '</pre>';
}