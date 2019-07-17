<?php 
    session_start();
    $id = $_SESSION["id"];
?>
<html>
	<head>
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
		<link rel="stylesheet" href="./../styles/bootstrap.css">
		
        <link rel="stylesheet" href="./../styles/styles.css">
        <link rel="stylesheet" href="./styles/style.css">
        <link rel="stylesheet" href="./styles/registerlogin.css">
        <title>Your Question</title>
	</head>
	<body>
		<div>
            <?php include './../header.php' ?>   
        </div>
        <div class="container box">
            <h3>Your Questions</h3>
            <div class="row">
                <div class="unanswerd col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <h4>Unanswerd...</h4>
                    <div class="searchbar">
                        <input type="text" id="search2" placeholder="Type Your Search..." class="search">
                    </div>
                    <?php                                                     
                        $conn = new mysqli("localhost", "root", "", "cwcapsule");
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        } 
                        $sql = "SELECT subjects.subjectName, questionanswer.question, questionanswer.questionId, questionanswer.quesAttachment, questionanswer.quesAttachmentFile FROM questionanswer INNER JOIN subjects ON subjects.subjectId = questionanswer.subjectId WHERE studentId = '$id' AND answerId IS NULL";
                        $result = $conn->query($sql);
                    ?>
                    <table id="detailTable2">
                        <thead>   
                            <th>Subject</th>
                            <th>Question</th>
                            <th>Attachment</th>
                            <th></th>
                        </thead>
                        <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()){
                                    echo "<tr>";
                                    echo "<td>" . $row["subjectName"] . "</td>";
                                    echo "<td>" . $row["question"] . "</td>";
                                    if($row["quesAttachment"] == '0'){
                                        echo "<td>No File Attach</td>";
                                    }else{
                                        echo "<td>" . $row["quesAttachmentFile"] . "</td>";
                                    }
                                    echo "<td><a href='viewQuestionAnswer.php?id=" . $id . "&qid=" . $row["questionId"] . "&sub=" . $row["subjectName"] . "'>View</a>";
                                    // echo "<span style='color:red;' onclick = 'deleteSubject(".$id.")'>Delete &#10006;</span>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }else{
                                echo "<tr><td colspan='4' style='text-align:center'>No result</tr>";
                            }
                            $conn->close();
                        ?>
                    </table>
                </div>
                <div class="answerd col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <h4>Answerd...</h4>
                    <div class="searchbar">
                        <input type="text" id="search" placeholder="Type Your Search..." class="search">
                    </div>
                    <?php                                                     
                        $conn = new mysqli("localhost", "root", "", "cwcapsule");
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        } 
                        $sql = "SELECT  subjects.subjectName, questionanswer.question, questionanswer.questionId, questionanswer.quesAttachment, questionanswer.quesAttachmentFile  FROM questionanswer INNER JOIN subjects ON subjects.subjectId = questionanswer.subjectId WHERE answerId IS NOT NULL";
                        $result = $conn->query($sql);
                    ?>
                    <table id="detailTable1">
                        <thead>   
                            <th>Subject</th>
                            <th>Question</th>
                            <th>Attachment</th>
                            <th></th>
                        </thead>
                        <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()){
                                    echo "<tr>";
                                    echo "<td>" . $row["subjectName"] . "</td>";
                                    echo "<td>" . $row["question"] . "</td>";
                                    if($row["quesAttachment"] == '0'){
                                        echo "<td>No File Attach</td>";
                                    }else{
                                        echo "<td>" . $row["quesAttachmentFile"] . "</td>";
                                    }
                                    echo "<td><a href='viewQuestionAnswer.php?id=" . $id . "&qid=" . $row["questionId"] . "&sub=" . $row["subjectName"] . "'>View</a>";
                                    // echo "<span style='color:red;' onclick = 'deleteSubject(".$id.")'>Delete &#10006;</span>"
                                    ECHO "</td>";
                                    echo "</tr>";
                                }
                            }else{
                                echo "<tr><td colspan='4' style='text-align:center'>No result</tr>";
                            }
                            $conn->close();
                        ?>
                    </table>
                </div>
            </div>         
        </div>

        <script>
            function filterTable(event) {
                var filter = event.target.value.toUpperCase();
                var rows = document.querySelector("#detailTable1 tbody").rows;
                
                for (var i = 0; i < rows.length; i++) {
                    var firstCol = rows[i].cells[1].textContent.toUpperCase();
                    var secondCol = rows[i].cells[2].textContent.toUpperCase();
                    var thirdCol = rows[i].cells[0].textContent.toUpperCase();
                    if (firstCol.indexOf(filter) > -1 || secondCol.indexOf(filter) > -1 || thirdCol.indexOf(filter) > -1) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }      
                }
            }
            document.querySelector('#search').addEventListener('keyup', filterTable, false);

            function filterTable2(event) {
                var filter = event.target.value.toUpperCase();
                var rows = document.querySelector("#detailTable2 tbody").rows;
                
                for (var i = 0; i < rows.length; i++) {
                    var firstCol = rows[i].cells[1].textContent.toUpperCase();
                    var secondCol = rows[i].cells[2].textContent.toUpperCase();
                    var thirdCol = rows[i].cells[0].textContent.toUpperCase();
                    if (firstCol.indexOf(filter) > -1 || secondCol.indexOf(filter) > -1 || thirdCol.indexOf(filter) > -1) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }      
                }
            }
            document.querySelector('#search2').addEventListener('keyup', filterTable2, false);
        </script>

	</body>
</html>