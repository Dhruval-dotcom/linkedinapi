<?php
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    $result = json_decode($response);
    $_SESSION['auth_token'] = $result -> access_token;
    echo $_SESSION['auth_token'];
    curl_close($curl); 



    $url ="https://api.linkedin.com/v2/me";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);

    $headers = array(
        "Authorization: Bearer {$_SESSION['auth_token']}",
        "Content-Type: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($curl);

    $result_me = json_decode($response);
    $_SESSION['id'] = $result_me -> id;
    $_SESSION['last_name'] = $result_me -> localizedLastName;
    $_SESSION['first_name'] = $result_me -> localizedFirstName;
    $_SESSION['displayImage'] =$result_me->profilePicture->displayImage;
    curl_close($curl); 



    $url ="https://api.linkedin.com/v2/me?projection=('{$_SESSION['id']}','{$_SESSION['first_name']}','{$_SESSION['last_name']}',profilePicture(displayImage~:playableStreams))";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);

    $headers = array(
        "Authorization: Bearer {$_SESSION['auth_token']}",
        "Content-Type: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    $result_profile = json_decode($response);
    $_SESSION['image_link'] = $result_profile -> profilePicture -> {'displayImage~'} -> elements[3] -> identifiers[0] -> identifier;
    echo $_SESSION['image_link'];