<?php
	require ("includes/config.php");
	require ("includes/class/service.class.php");
	require ("includes/class/gallery.class.php");
	require ("includes/class/video.class.php");

	$service = new Service();
	$gallery = new Gallery();
	$video = new Video();

	$serverName = 'http://' . $_SERVER['SERVER_NAME'] . '/';

	// Services
	$imageServiceDefault = 'http://' . $_SERVER['SERVER_NAME'] . '/images/no_avaliable.jpg';
	$permalinkServiceDefault = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $messages_p["app_menu_service"] . '/';

	// Galleries
	$gallImageDefault = '/images/no_avaliable.jpg';
	$permalinkGalleryDefault = '/' . $messages_p["app_menu_gallery"] . '/';

	// Videos
	$videoImageDefault = '/images/no_avaliable.jpg';
	$permalinkVideoDefault = '/0/16/' . $messages_p["app_menu_videos"] . '/';



	$maxWords = 100;

	$result = array();

	$result[0] = array(
		"permalink" => "#",
		"image" => "./images/noimg.png",
		"title" => "No se encontraton Datos"
	);

	if (isset($_POST['q']) && !empty($_POST['q'])) {
		$q = fieldSecure($_POST['q']);

		$index = 0;

		// Services
		$listServices = $service->serviceList($q, ' ORDER BY s.serv_highlight DESC, s.serv_order ', 0, 0, 1, 0, $_SESSION["lang"]);
		$countServices = count ($listServices);

		for ($i = 0; $i < $countServices; $i++) {
            $servImage = $imageServiceDefault;
            if (!empty ($listServices[$i]->serv_image)) {
                $path_img = 'file_upload/service/200x150/' . $listServices[$i]->serv_image;
                if (file_exists($path_img)) {
                    $servImage = $serverName . $path_img;
                }
            }

            $result[$index] = array(
				"permalink" => $permalinkServiceDefault . $listServices[$i]->serv_code . '/' . formatToUrl($listServices[$i]->serv_name),
				"image" => $servImage,
				"title" => truncate($listServices[$i]->serv_name, $maxWords)
			);

            ++$index;
        }
		
		// Galleries
        $listGalleries = $gallery->galleriesList($q, 'ORDER BY gall_order', 0, 0, 1, $_SESSION["lang"]);
		$countGalleries = count ($listGalleries);

		for ($i = 0; $i < $countGalleries; $i++)	{
			$gallImage = $gallImageDefault;
			if (! empty ($listGalleries[$i]->img_rename)) {
				$path_img = "file_upload/gallery/200x120/".$listGalleries[$i]->img_rename;
				if (file_exists ($path_img)) {
					$gallImage = $serverName . $path_img;
				}
			}

			$result[$index] = array(
				"permalink" => $permalinkGalleryDefault . $listGalleries[$i]->gall_code . '/' . formatToUrl($listGalleries[$i]->gall_name),
				"image" => $gallImage,
				"title" => truncate($listGalleries[$i]->gall_name, $maxWords)
			);

            ++$index;
		}

		// Videos
		$listVideos = $video->videosList($q, ' ORDER BY v.vid_order ', 0, 0, 1, $_SESSION["lang"]);
		$countVideos = count ($listVideos);
		for ($i = 0; $i < $countVideos; $i++)	{
			$pathVideo = "file_upload/videos/file/".$listVideos[$i]->vid_file;
			
			if ($listVideos[$i]->vid_type == 1 && ! file_exists ($pathVideo)) {
				continue;
			}
			
			$path_img = "file_upload/videos/images/200x122/".$listVideos[$i]->vid_image;
			$videoImage = $videoImageDefault;
		
			if (! empty ($listVideos[$i]->vid_image) && file_exists ($path_img)) {
				$videoImage = $serverName . $path_img;
			} elseif ($listVideos[$i]->vid_type == 2) {
				$img_youtube = "http://img.youtube.com/vi/".$listVideos[$i]->vid_file."/1.jpg";
				if ($conex = @fopen ($img_youtube, "rt")) {
					$videoImage = $img_youtube;
				}
			}

			$result[$index] = array(
				"permalink" => $permalinkVideoDefault . $listVideos[$i]->vid_code.'/'.formatToUrl($listVideos[$i]->vid_name),
				"image" => $videoImage,
				"title" => truncate($listVideos[$i]->vid_name, $maxWords)
			);

            ++$index;
		}		
		

	}


	/***
	$result[1] = array(
		"permalink" => "clicksy.co",
		"image" => "./images/noimg.png",
		"title" => "abus colombia ok"
	);
	*/
	
//	header('HTTP/1.1 200 OK');
	echo json_encode($result);
