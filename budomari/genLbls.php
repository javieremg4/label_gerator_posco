<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        iframe{
            height: 100%;
            margin: 50px 10%;
            width: 80%;
        }
    </style>
</head>
<body>
    <div id="server_answer" style = "border: 1px solid red;"></div>
    <?php
        echo "<button onclick='pdfGenerator(".json_encode($lbls).")'>Generar todas las etiquetas</button>";
        $curPart = null;
        foreach($groupArray as $index => $groupLbls) {
            $curPart = $groupLbls[0];
            echo "<button id='".$index."' onclick='pdfGenerator(".json_encode($groupLbls).")'>".$curPart['part']."</button>";
        }
    ?>
    <button onclick="download()">Ver pdf</button>
    <hr>
    <iframe src="" frameborder="0" title="test" id="pdfFrame"></iframe>

    <script src="../js/libraries/jquery-3.4.1.min.js"></script>
    <script src="../js/libraries/jspdf.min.js"></script>
    <script src="genLbls.js"></script>
</body>
</html>
