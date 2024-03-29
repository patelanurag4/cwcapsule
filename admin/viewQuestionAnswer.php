<?php

    include "./../databaseConn.php";
    include "./../configurl.php";
    
    $questionId = $_GET["qid"];
    $sub = $_GET["sub"];

    $query = "SELECT studentId FROM questionanswer WHERE questionId = $questionId";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $studentId = $row["studentId"];

    $query = "SELECT studentName FROM students WHERE studentId = $studentId";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $stdName = $row["studentName"];

    $question = "./../questionanswer/" . $sub . "/questions/" . $questionId . ".html";
    $answer = "./../questionanswer/" . $sub . "/answers/" . $questionId . ".html";

    include "./../databaseConn.php";

    $sql = "SELECT * FROM questionanswer WHERE questionId = '$questionId'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $answerShow = "block";
    $buttonShow = "block";
    if($row["answerId"] == NULL){
        $answerShow = "none";
        $buttonShow = "block";
    }
    else{
        $answerShow = "block";
        $buttonShow = "none";  
    }
    if(isset($_POST['submit'])){
        $sql = "UPDATE questionAnswer SET answering='1' WHERE questionId = '$questionId' ";

        if ($conn->query($sql) === TRUE) {
            header("Location: " . $url . " teachers/answering.php?qid=".$questionId."&sName=".$sub);
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $conn->close();
    }
?>
<html>
	<head>
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
		<link rel="stylesheet" href="./../styles/bootstrap.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		
        <link rel="stylesheet" href="./../styles/styles.css">
        <link rel="stylesheet" href="./styles/style.css">
        <link rel="stylesheet" href="./../styles/registerlogin.css">
        <title>Your Question</title>
	</head>
	<body>
		<div>
            <?php include './header.php' ?>   
        </div>
        <div class="container box">
            <div class="question">
                <h4><u>Question:</u></h4>
                <?php 
                    include $question;
                    if($row["quesAttachment"] == '1'){
                        echo "<h6>Attachments:</h6>";                    
                        echo "<a href = './../questionanswer/" . $sub ."/attachments/" . $row['quesAttachmentFile'] ."' target='_blank'>" . $row['quesAttachmentFile'] . "</a>";
                    }
                ?>
            </div>  
            <div class="answer" style="display:<?php echo $answerShow; ?>">
                <h4><u>Answer:</u></h4>
                <?php 
                    include $answer;
                    if($row["answerAttachment"] == '1'){
                        echo "<h6>Attachments:</h6>";                    
                        echo "<a href = './../questionanswer/" . $sub ."/attachments/" . $row['answerAttachmentFile'] ."' target='_blank'>" . $row['answerAttachmentFile'] . "</a>";
                    }
                ?>
            </div>  
        </div>        
        <div>
            <?php include './../footer.php' ?>   
        </div>
	</body>
</html>