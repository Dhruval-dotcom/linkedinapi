<?php
session_start();

function api_response ($url, $data, $header){
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($curl);
    curl_close($curl);
    
    return json_decode($response);
}

$_POST['desc'] .= $_POST['tags'];

function createpost(){
        
    $media_str = '';

    foreach ($_FILES['file']['tmp_name'] as $img_name) {

    //------------------------GETTING URL FOR UPLOADING IMAGE---------------------
        $data_img = '{
            "registerUploadRequest": {
                "recipes": [
                    "urn:li:digitalmediaRecipe:feedshare-image"
                ],
                "owner": "urn:li:person:'.$_SESSION['id'].'",
                "serviceRelationships": [
                    {
                        "relationshipType": "OWNER",
                        "identifier": "urn:li:userGeneratedContent"
                    }
                ]
            }
        }';
        
        $headers_img = array(
            "Authorization: Bearer {$_SESSION['auth_token']}",
            "Content-Type: application/json",
        );
        
        $url_img = "https://api.linkedin.com/v2/assets?action=registerUpload";
        
        
        $result_img = api_response($url_img, $data_img, $headers_img);
        
        $uploadUrl = $result_img -> value -> uploadMechanism -> {'com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest'} -> uploadUrl;
        $asset = $result_img -> value -> asset;

        $media_str .= '{
            "status": "READY",
            "description": {
                "text": "Center stage!"
            },
            "media": "'.$asset.'",
            "title": {
                "text": "LinkedIn Talent Connect 2021"
            }
        },';


        //----------------------uploading image----------------------------------------
        $url_upload = $uploadUrl;
        $cfile = new CURLFile($img_name);
        $data_upload = array('file' => $cfile);
        $header_upload = array(
            "Authorization: Bearer {$_SESSION['auth_token']}",
            "Content-Type: multipart/form-data",
        );

        $response_img_upload = api_response($url_upload, $data_upload, $header_upload);
    }

    $media_str = substr($media_str, 0, strlen($media_str)-1);
    //------------------CERATING A POST---------------------------------------------
    $data_post = '{
        "author": "urn:li:person:'.$_SESSION['id'].'",
        "lifecycleState": "PUBLISHED",
        "specificContent": {
            "com.linkedin.ugc.ShareContent": {
                "shareCommentary": {
                    "text": "'.$_POST['desc'].'"
                },
                "shareMediaCategory": "IMAGE",
                "media": [
                    '.$media_str.'
                ]
            }
        },
        "visibility": {
            "com.linkedin.ugc.MemberNetworkVisibility": "PUBLIC"
        }
    }';
    $url_post = 'https://api.linkedin.com/v2/ugcPosts';

    $header_post = array(
        "Authorization: Bearer {$_SESSION['auth_token']}",
        "Content-Type: application/json",
    );
    $response_post = api_response($url_post, $data_post, $header_post);
    print_r($response_post);
}

function createarticle(){
    $data_article = '{
        "author": "urn:li:person:'.$_SESSION['id'].'",
        "lifecycleState": "PUBLISHED",
        "specificContent": {
            "com.linkedin.ugc.ShareContent": {
                "shareCommentary": {
                    "text": "'.$_POST['desc'].'"
                },
                "shareMediaCategory": "ARTICLE",
                "media": [
                    {
                        "status": "READY",
                        "description": {
                            "text": "'.$_POST['urldesc'].'"
                        },
                        "originalUrl": "'.$_POST['url'].'",
                        "title": {
                            "text": "'.$_POST['title'].'"
                        }
                    }
                ]
            }
        },
        "visibility": {
            "com.linkedin.ugc.MemberNetworkVisibility": "PUBLIC"
        }
    }';
    $url_article = "https://api.linkedin.com/v2/ugcPosts";
    $header_article = array(
        "Authorization: Bearer {$_SESSION['auth_token']}",
        "Content-Type: application/json",
    );
    $response_article = api_response($url_article, $data_article, $header_article);
    print_r($response_article);
}

function createtext(){
    $data_text = '{
        "author": "urn:li:person:'.$_SESSION['id'].'",
        "lifecycleState": "PUBLISHED",
        "specificContent": {
            "com.linkedin.ugc.ShareContent": {
                "shareCommentary": {
                    "text": "'.$_POST['desc'].'"
                },
                "shareMediaCategory": "NONE"
            }
        },
        "visibility": {
            "com.linkedin.ugc.MemberNetworkVisibility": "PUBLIC"
        }
    }';
    $url_text = "https://api.linkedin.com/v2/ugcPosts";
    $header_text = array(
        "Authorization: Bearer {$_SESSION['auth_token']}",
        "Content-Type: application/json",
    );
    $response_text = api_response($url_text, $data_text, $header_text);
    print_r($response_text);
}

$_POST['page'] == 'article' ? createarticle():($_POST['page'] == 'post' ? createpost():createtext());


