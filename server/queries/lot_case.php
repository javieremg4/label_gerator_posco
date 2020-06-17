<?php
    require "../queries/connection.php";
    $query = "SELECT no_lote FROM lote ORDER BY no_lote";
    $result = mysqli_query($connection,$query);
    if($result){
        $lotExp = "/^\d[A-Z\d][A-Z\d]+\-{0,1}[A-Z\d]+$/";
        $hyphen = "/\-/";
        $case1 = "/^9A[A-Z\d]+\-[A-Z\d]+$/";
        $case2 = "/^98[A-Z\d]+\-[A-Z\d]+$/";
        $case3 = "/^\d{2}[A-Z\d]+\-[A-Z\d]+$/";
        $case4 = "/^98[A-Z\d]+R$/";
        $case5 = "/^\d{2}[A-Z\d]+$/";
        $case6 = "/^98[A-Z\d]+(A|B|C|D){2}R\-[A-Z\d]+$/";
        $case7 = "/^9A[A-Z\d]+$/";
        
        $countlotExp = 0;
        $content1 = "";
        $content2 = "";
        $content3 = "";
        $content4 = "";
        $content5 = "";
        $content6 = "";
        $content7 = "";
        $contentFail = "";
        $count1 = 0;
        $count2 = 0;
        $count3 = 0;
        $count4 = 0;
        $count5 = 0;
        $count6 = 0;
        $count7 = 0;
        $countFail = 0;
        while($info = mysqli_fetch_array($result)){
            if(preg_match($lotExp,$info['no_lote'])===1){
                if(preg_match($hyphen,$info['no_lote'])===1){
                    if(preg_match($case1,$info['no_lote'])){
                        $content1 .= $info['no_lote']."<br>";
                        $count1 += 1;
                    }else if(preg_match($case6,$info['no_lote'])){
                        $content6 .= $info['no_lote']."<br>";
                        $count6 += 1;
                    }else if(preg_match($case2,$info['no_lote'])){
                        $content2 .= $info['no_lote']."<br>";
                        $count2 += 1;
                    }else if(preg_match($case3,$info['no_lote'])){
                        $content3 .= $info['no_lote']."<br>";
                        $count3 += 1;
                    }else{
                        $contentFail .= $info['no_lote']."<br>";
                        $countFail += 1;
                    }
                }else{
                    if(preg_match($case7,$info['no_lote'])){
                        $content7 .= $info['no_lote']."<br>";
                        $count7 += 1;
                    }else if(preg_match($case4,$info['no_lote'])){
                        $content4 .= $info['no_lote']."<br>";
                        $count4 += 1;
                    }else if(preg_match($case5,$info['no_lote'])){
                        $content5 .= $info['no_lote']."<br>";
                        $count5 += 1;
                    }else{
                        $contentFail .= $info['no_lote']."<br>";
                        $countFail += 1;
                    }
                }
                $countlotExp += 1;
            }else{
                $countFail += 1;
            }
        }
        echo "lotExp = ".$countlotExp."<br>"."Fail = ".$countFail;
        echo "<table border='1'>
                <tr><th>Caso 1<th>Caso 2<th>Caso 3<th>Caso 4<th>Caso 5<th>Caso 6<th>Caso 7<th>Errores".
                "<tr><td>".$count1."<td>".$count2."<td>".$count3."<td>".$count4."<td>".$count5."<td>".$count6."<td>".$count7."<td>".$countFail.
                "<tr style='vertical-align: top'><td>".$content1."<td>".$content2."<td>".$content3."<td>".$content4."<td>".$content5."<td>".$content6."<td>".$content7."<td>".$contentFail.
            "</table>";
    }

?>
