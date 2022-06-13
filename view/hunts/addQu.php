<link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("hunt.css") ?>">
<section class="addQu-dark">
    <form method="post" action="<?php echo File::fileDirection("/hunts/createlist") ?>">
        <div style="width: 100%;">
            <h2 id="h-title" class="visually-hidden" data-hid="<?php echo $hunt->getHunt_Id() ?>"><?php echo $hunt->getHunt_Title() ?></h2>
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <div id="addedQu"></div>
            <div id="createhunt" class="mb-3"><button id="validateBtn" class="btn btn-primary d-block w-100" type="button">Créer</button></div>
            <a class="forgot" href="?action=createquestion&controller=question">No questions? create some!</a>
        </div>
    </form>
    <div id="questions_list">
        <h2 class="visually-hidden">Mes questions</h2>
        <?php
            if (isset($questions)){
                foreach ($questions as $qu){
                    if($qu->getUser_Id() == $usr->getUser_id())
                        echo "
                            <div class='add_qu' data-quid='".$qu->getQu_Id()."'>
                                <div>
                                    <p class='quTit'>".$qu->getQu_Title()."</p>
                                    <p class='quTxt'>".$qu->getQu_Text()."</p>
                                </div>
                                <div class='add_icon'>
                                    <i class='fas fa-plus'></i>
                                </div>
                                <input type='hidden' name='qu_id[]' value='".$qu->getQu_Id()."'>
                                <input type='hidden' name='qu_num[]' value=''>
                            </div>
                        ";
                }
            }
        ?>
    </div>

    <script>
        function checker(){
            if ($('#addedQu').html()){
                $("#createhunt button").prop('disabled', false);
            }
            else{
                $("#createhunt button").prop('disabled', true);
            }
        }
        checker();

        $(document).ready(function (){
            $(document).on('click', '.add_qu', function(e){
                $(this).removeClass("add_qu");
                $(this).addClass("rm_qu");
                //$(this).find('i').toggleClass("fa-plus fa-dash");
                $("#addedQu").append($(this));
                checker();
            });

            $(document).on('click', '.rm_qu', function(){
                $(this).removeClass("rm_qu");
                $(this).addClass("add_qu");
                //$(this).find('i').toggleClass("fa-dash fa-plus");
                $("#questions_list").append($(this));
                checker();
            })

            $("#validateBtn").off("click").on("click", () => {
                $("#addedQu > .rm_qu").each(function( i ) {
                    let quid = $("#addedQu > .rm_qu")[i].dataset["quid"];
                    let huntid = $("#h-title")[0].dataset["hid"];
                    $.ajax({
                        url:'<?php echo File::fileDirection("/hunts/".$hunt->getHunt_Id()."/createlist") ?>',
                        type: "POST",
                        data: {
                            "qu_id": quid,
                            "number": i
                        }
                    })
                });
            });
        });
    </script>
</section>