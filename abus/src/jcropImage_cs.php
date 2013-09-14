<?php

    require ("../includes/class/resize/imagen.class.php5");
    require ("../includes/config.php");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    $imageObj = new Imagen();

    // 850px de ancho y 567px de alto.
    // 950px de ancho y 670px de alto.

    $titlePage = 'JCrop Image :: ABUS'; // título de la página
    $maxSizeMb = 5; // tamaño máximo (en Mb) de la imagen a cargar.
    $maxImageSize = (1148576 * $maxSizeMb);// Approx 3MB
    $allowedExtensionsList = array ('jpg'); // extensiones permitidas a cargar
    $uploadDir = 'upload_jcrop';
    $uploadPath = $uploadDir . '/';
    $cropperDir = '../file_upload/images_bank';
    $cropperPath = $cropperDir . '/';
    $divContent = ''; // div donde será alojada la imagen recien recortada.
    $idInputHidden = ''; // id del campo oculto donde se guarda el renombre que se le asigna a la imagen recortada.
    $function = ''; // funcion a llamar en el script que llamo al fancy despues de recortar la imagen.


    $widthAreaSelection = 0; // ancho ideal a seleccionar de la imagen.
    $hightAreaSelection = 0; // alto ideal a seleccionar de la imagen.
    $widthAreaSelectionAux = 0; // ancho del área a seleccionar de la imagen.
    $hightAreaSelectionAux = 0; // alto del área a seleccionar de la imagen.
    $positionXAreaSelection = 0; // indica la coordenada en X desde donde se selecciona el área.
    $positionYAreaSelection = 0; // indica la coordenada en Y desde donde se selecciona el área.


    $imageMaxWidth = 950; // ancho máximo para mostrar en el jcrop


    $msjValidationImageMaxSize = 'El tamaño máximo permitido es: ' . $maxSizeMb . ' Mb'; // replaceMessage($messages['validationJcrop_masxSize'], array($mb_max.' Mb'))
    $msgValidationExtensionAllowed = 'La extensión de la imagen no esta soportada. Extensiones soportadas: ' . $allowedExtensionsList[0]; // $messages['validationJcrop_format']
    $msgValidationSelectImage = 'Seleccione una imagen para cargar'; // $messages['validationJcrop_selectImage']
    $msgErrorLoadImage = 'Ha ocurrido un error al tratar de cargar la imagen';
    $msgErrorCropImage = 'Ha ocurrido un error al tratar de recortar la imagen';

    $msgSelectImageArea = "Debes seleccionar un área de la imagen para continuar"; // jcrop_message_select_image

    $lblAtention = 'Atención:';
    $lblEndCrop = 'Finalizar Corte';

    $messageValue = ''; // mensaje de [alerta, error, información] en caso de que exista.
    $messageType = 'warning'; // alerta por defecto

    $tmpImageName = '';
    $scaleResize = 1; // escala a la que se redimensiona la imagen para ser mostrada en pantalla
    $pathImageToCrop = ''; // contiene la ruta de la imagen a ser manipulada por el JCrop.
    
    // se crea la carpeta donde se almacenan las imágenes a manipular por el jcrop
    if (!is_dir ($uploadDir)) {
        // se crea la carpeta.
        mkdir($uploadDir, 0777);
        // se le cambia el modo, todos los permisos.
        chmod($uploadDir, 0777);       
    }

    // se crea la carpeta donde se almacenan las imágenes recortadas por el jcrop
    if (!is_dir ($cropperDir)) {
        // se crea la carpeta.
        mkdir($cropperDir, 0777);
        // se le cambia el modo, todos los permisos.
        chmod($cropperDir, 0777);       
    }

    // variables que se reciben por GET | POST
    if (isset ($_GET['tmpImageName']) && !empty ($_GET['tmpImageName'])) {
        $tmpImageName = $_GET['tmpImageName'];
        if (file_exists ($uploadPath . $tmpImageName)) {
            $pathImageToCrop = $uploadPath . $tmpImageName;
        } else {
            $messageValue = $msgErrorLoadImage;
            $messageType = 'error';
            $tmpImageName = '';
        }
    } elseif (isset ($_POST['tmpImageName']) && !empty ($_POST['tmpImageName'])) {        
        $tmpImageName = $_POST['tmpImageName'];
    }

    if (isset ($_GET['scaleResize']) && !empty ($_GET['scaleResize'])) {
        $scaleResize = $_GET['scaleResize'];        
    } elseif (isset ($_POST['scaleResize']) && !empty ($_POST['scaleResize'])) {        
        $scaleResize = $_POST['scaleResize'];
    }

    if (isset ($_GET['widthAreaSelection']) && !empty ($_GET['widthAreaSelection'])) {
        $widthAreaSelection = $_GET['widthAreaSelection'];
    } elseif (isset ($_POST['widthAreaSelection']) && !empty ($_POST['widthAreaSelection'])) {        
        $widthAreaSelection = $_POST['widthAreaSelection'];
    }

    if (isset ($_GET['hightAreaSelection']) && !empty ($_GET['hightAreaSelection'])) {
        $hightAreaSelection = $_GET['hightAreaSelection'];
    } elseif (isset ($_POST['hightAreaSelection']) && !empty ($_POST['hightAreaSelection'])) {        
        $hightAreaSelection = $_POST['hightAreaSelection'];
    }

    if (isset ($_GET['widthAreaSelectionAux']) && !empty ($_GET['widthAreaSelectionAux'])) {
        $widthAreaSelectionAux = $_GET['widthAreaSelectionAux'];
    } elseif (isset ($_POST['widthAreaSelectionAux']) && !empty ($_POST['widthAreaSelectionAux'])) {        
        $widthAreaSelectionAux = $_POST['widthAreaSelectionAux'];
    }

    if (isset ($_GET['hightAreaSelectionAux']) && !empty ($_GET['hightAreaSelectionAux'])) {
        $hightAreaSelectionAux = $_GET['hightAreaSelectionAux'];
    } elseif (isset ($_POST['hightAreaSelectionAux']) && !empty ($_POST['hightAreaSelectionAux'])) {        
        $hightAreaSelectionAux = $_POST['hightAreaSelectionAux'];
    }

    if (isset ($_GET['positionXAreaSelection']) && !empty ($_GET['positionXAreaSelection'])) {
        $positionXAreaSelection = $_GET['positionXAreaSelection'];
    } elseif (isset ($_POST['positionXAreaSelection']) && !empty ($_POST['positionXAreaSelection'])) {        
        $positionXAreaSelection = $_POST['positionXAreaSelection'];
    }

    if (isset ($_GET['positionYAreaSelection']) && !empty ($_GET['positionYAreaSelection'])) {
        $positionYAreaSelection = $_GET['positionYAreaSelection'];
    } elseif (isset ($_POST['positionYAreaSelection']) && !empty ($_POST['positionYAreaSelection'])) {        
        $positionYAreaSelection = $_POST['positionYAreaSelection'];
    }

    if (isset ($_GET['divContent']) && !empty ($_GET['divContent'])) {
        $divContent = $_GET['divContent'];
    } elseif (isset ($_POST['divContent']) && !empty ($_POST['divContent'])) {        
        $divContent = $_POST['divContent'];
    }

    if (isset ($_GET['idInputHidden']) && !empty ($_GET['idInputHidden'])) {
        $idInputHidden = $_GET['idInputHidden'];
    } elseif (isset ($_POST['idInputHidden']) && !empty ($_POST['idInputHidden'])) {        
        $idInputHidden = $_POST['idInputHidden'];
    }

    if (isset ($_GET['function']) && !empty ($_GET['function'])) {
        $function = $_GET['function'];
    } elseif (isset ($_POST['function']) && !empty ($_POST['function'])) {        
        $function = $_POST['function'];
    }


    // Fín, variables GET | POST

    // llega una nueva imagen a previsualizar.
    // 
    if (! empty ($_FILES['imageJcrop']['tmp_name'])) {
        // llega una nueva imagen, la anterior se elimina por optimización de la librería.
        if (! empty ($tmpImageName) && file_exists ($uploadPath . $tmpImageName)) {
            unlink($uploadPath . $tmpImageName);
        }

        $imageTmpName   = $_FILES['imageJcrop']['tmp_name'];
        $imageSize      = $_FILES['imageJcrop']['size'];
        $imageName      = basename($_FILES['imageJcrop']['name']);
        $imageExtension = strtolower(substr($imageName, strrpos($imageName, '.') + 1));
        
        // Sólo se procesa la imagen si cumple con el formato y su tamaño es menor o igual al permitido.
        if ($_FILES['imageJcrop']['error'] == 0) {
            // se valida que el tamaño de la imagen son supere el permitido.
            if ( $imageSize > $maxImageSize ) {
                $messageValue = $msjValidationImageMaxSize . '<br />';
            }
            // se valida que la extensión de la imagen sea correcta.
            if (!in_array ($imageExtension, $allowedExtensionsList)) {
                $messageValue = $msgValidationExtensionAllowed . ' - ' . $imageExtension . '<br />';
            }
        } else {
            $messageValue = $msgValidationSelectImage . '<br />';
        }
        
        // todo esta bien, la imagen puede ser cargada.
        if (strlen ($messageValue) == 0) {
            $tmpImageName = date('U') . mt_rand() . '.' . $imageExtension;
            $tmpImageLocation = $uploadPath . $tmpImageName; // ruta de la imagen original

            move_uploaded_file ($imageTmpName, $tmpImageLocation);
            // se cambia el modo del archivo, todos los permisos
            chmod($tmpImageLocation, 0777); 
            
            $widthTmpImage = getImageWidth ($tmpImageLocation);
            $heightTmpImage = getImageHeight ($tmpImageLocation);

            if ($widthTmpImage > $imageMaxWidth){
                $scaleResize = ($imageMaxWidth / $widthTmpImage);
            }
            
            // se redimensiona la imagen que se usa para mostrar en pantalla.
            resizeImage ($tmpImageLocation, $widthTmpImage, $heightTmpImage, $scaleResize);

            $newImageWidth = getImageWidth ($tmpImageLocation);
            $newImageHeight = getImageHeight ($tmpImageLocation);

            $widthAreaSelectionAux = $widthAreaSelection;
            $hightAreaSelectionAux = $hightAreaSelection;
            
            if (($widthAreaSelection > 0) && ($hightAreaSelection > 0)) {
                // Existe un área predeterminada a seleccionar.
                $scaleAreaSelect = 1;
                if ($widthAreaSelection > $newImageWidth) {
                    // el área a seleccionar es más ancha que la imagen cargada, se calcula la escala.
                    $scaleAreaSelect = ($newImageWidth / $widthAreaSelection);
                } 

                if ($hightAreaSelection > $newImageHeight) {
                    // el área a seleccionar es más alta que la imagen cargada, se calcula la escala.
                    $scaleAux = ($newImageHeight / $hightAreaSelection);

                    if ($scaleAux < $scaleAreaSelect) {
                        $scaleAreaSelect = $scaleAux;
                    }
                }

                if ($scaleAreaSelect != 1) {
                    $widthAreaSelectionAux = ceil ($widthAreaSelection * $scaleAreaSelect);
                    $hightAreaSelectionAux = ceil ($hightAreaSelection * $scaleAreaSelect);
                }
            } else {
                // se selecciona toda la imagen cuando no llega una proporción de área a seleccionar.
                $widthAreaSelectionAux = $newImageWidth;
                $hightAreaSelectionAux = $newImageHeight;
            }

            $positionXAreaSelection = ceil ($newImageWidth - $widthAreaSelectionAux) / 2;
            $positionYAreaSelection = ceil ($newImageHeight - $hightAreaSelectionAux) / 2;
            // Se refresca la página para mostrar la imagen cargada.
            header('location:'.$_SERVER['PHP_SELF'].'?' 
                . 'tmpImageName='            . $tmpImageName
                . '&scaleResize='            . $scaleResize
                . '&widthAreaSelection='     . $widthAreaSelection
                . '&hightAreaSelection='     . $hightAreaSelection
                . '&widthAreaSelectionAux='  . $widthAreaSelectionAux
                . '&hightAreaSelectionAux='  . $hightAreaSelectionAux
                . '&positionXAreaSelection=' . $positionXAreaSelection
                . '&positionYAreaSelection=' . $positionYAreaSelection
                . '&divContent='             . $divContent
                . '&idInputHidden='          . $idInputHidden
                . '&function='               . $function


                );
            exit();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // finaliza el recorte de la imagen.
        $x1 = $_POST["x1"];
        $y1 = $_POST["y1"];
        $w  = $_POST["w"];
        $h  = $_POST["h"];
        
        if ( !empty ($tmpImageName) && file_exists ($uploadPath . $tmpImageName)) {
            $pathImageToCrop = $uploadPath . $tmpImageName; // ruta de la imagen a recortar
            $pathImageCropped = $cropperPath . $tmpImageName;// ruta donde quedará la iagen recortada

            $scaleAreaSelect = 1;
            if ($widthAreaSelection > 0 && $hightAreaSelection > 0) {
                // la imagen necesita un tamaño predeterminado
                if (($widthAreaSelection != $w) && ($w > 0)) {
                    // se ajusta la escala para tomar el ancho deseado
                    $scaleAreaSelect = ($widthAreaSelection / $w);
                } 

                if (($hightAreaSelection != $h) && ($h > 0)) {
                    // se ajusta la escala para tomar el alto deseado
                    $scaleAux = ($hightAreaSelection / $h);
                    if ($scaleAux < $scaleAreaSelect) {
                        $scaleAreaSelect = $scaleAux;
                    }
                }
            }

            $cropped = cropImage($pathImageCropped, $pathImageToCrop, $x1, $y1, ceil ($w * $scaleAreaSelect), ceil ($h * $scaleAreaSelect), $w, $h);
            
            if (file_exists($cropped)) {
                if (($widthAreaSelection > 0) && ($hightAreaSelection > 0)) {
                    $imageObj->redimensionarImagen($widthAreaSelection, $hightAreaSelection, $cropped, $cropped);
                }

                if (! empty ($pathImageToCrop) && file_exists ($pathImageToCrop)) {
                    // se elimina la imagen desde donde se hizo el recorte
                    unlink($pathImageToCrop);
                }

                if (!empty($divContent)) {
                    // existe un div para visualizar la imagen recien recortada.
                    echo "<script>parent.chargerImage('" . $tmpImageName . "', '" . $idInputHidden . "', '" . $divContent . "');</script>";
                } elseif (! empty ($function)) {
                    echo "<script>parent." . $function . "('" . $tmpImageName . "');</script>";
                } else {
                    echo "<script> parent.close_fancy();</script>";         
                }

                $messageValue = 'OK';
                $messageType = 'success';
            } else {
                $messageValue = 'Error al recortar la imagen';
                $messageType = 'error';
            }
        } else {
            $messageValue = $msgErrorCropImage;
            $messageType = 'error';
        }
        
    }

    // No es necesario modificar las siguientes funciones.
    /**
    *   Función responsable de obtener el alto de una imagen
    *   @param $imageLocation, ruta en donde se encuentra la imagen.
    *   @return int, alto de la imagen.
    */
    function getImageHeight($imageLocation) {
        $sizes = getimagesize($imageLocation);
        $height = $sizes[1];
        return $height;
    }
    
    /**
    *   Función responsable de obtener el alto de una imagen
    *   @param $imageLocation, ruta en donde se encuentra la imagen.
    *   @return int, alto de la imagen.
    */
    function getImageWidth($imageLocation) {
        $sizes = getimagesize($imageLocation);
        $width = $sizes[0];
        return $width;
    }

    /**
    * Función que redimensiona una imagen.
    * @param $imageLocation, ubicación de la imagen a redimencionar.
    * @param $width, ancho a redimensionar.
    * @param $height, alto a redimensionar.
    * @param $scale, escala a la que se desea redimensionar la imagen.
    * @param $imageResizeName, ubicación de la imagen redimensionada.
    * @return 
    */
    function resizeImage($imageLocation, $width, $height, $scale = 1, $imageResizeName = '') {
        if (empty ($imageResizeName)) {
            // si no viene una ubicación para la imagen se reemplaza la original
            $imageResizeName = $imageLocation;
        }
        $rojo = 255;  $verde = 255;  $azul = 255;

        $newImageWidth = ceil ($width * $scale);
        $newImageHeight = ceil ($height * $scale);
        $newImage = imagecreatetruecolor ($newImageWidth, $newImageHeight);
        
        $bg = imagecolorallocate($newImage, $rojo, $verde, $azul);//color fondo    
        imagefill($newImage,0,0,$bg);

        $source = imagecreatefromjpeg ($imageLocation);
        imagecopyresampled ($newImage, $source, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $width, $height);
        imagejpeg ($newImage, $imageResizeName, 100);
        chmod ($imageLocation, 0777);
        return $imageLocation;
    }

    /**
    * Función que realiza el corte de la imagen cuando ya se tiene el área para hacerlo.
    * @param $pathCropperImage, ruta completa donde se guardará la imagen despues de recortarla.
    * @param $pathImageToCrop, ruta completa donde se encuentra la imagen a recortar.
    * @param $startWidth, posición en x desde donde se sacará el recorte.
    * @param $startHeight, posición en y desde donde se sacará el recorte.
    * @param $newImageWidth, Destination width.
    * @param $newImageHeight, Destination height.
    * @param $widthImageToCrop, ancho del recorte que se desea de la imagen a recortar.
    * @param $heightImageToCrop, alto del recorte que se desea de la imagen a recortar.
    * @return
    */
    function cropImage($pathCropperImage, $pathImageToCrop, $startWidth, $startHeight, $newImageWidth, $newImageHeight, $widthImageToCrop, $heightImageToCrop){      
        if ($newImageWidth == 0 || $newImageHeight == 0) {
            return NULL;
        }
        $newImage = imagecreatetruecolor ($newImageWidth, $newImageHeight);
        $source = imagecreatefromjpeg($pathImageToCrop);
        imagecopyresampled($newImage, $source, 0, 0, $startWidth, $startHeight, $newImageWidth, $newImageHeight, $widthImageToCrop, $heightImageToCrop);
        imagejpeg($newImage, $pathCropperImage, 100);
        chmod($pathCropperImage, 0777);
        return $pathCropperImage;
    }