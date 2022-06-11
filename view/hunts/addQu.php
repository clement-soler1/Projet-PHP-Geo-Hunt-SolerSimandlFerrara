<link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("hunt.css") ?>">
<section class="addQu-dark">
    <form method="post" action="<?php echo File::fileDirection("/hunts/create") ?>">
        <div style="width: 100%;">
            <h2 class="visually-hidden">Nom de piste</h2>
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <div id="addedQu"></div>
            <div id="createhunt" class="mb-3"><button class="btn btn-primary d-block w-100" type="submit">Créer</button></div>
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
                            <div class='add_qu'>
                                <div>
                                    <p class='quTit'>".$qu->getQu_Title()."</p>
                                    <p class='quTxt'>".$qu->getQu_Text()."</p>
                                </div>
                                <div class='add_icon'>
                                    <i class='fas fa-plus'></i>
                                </div>
                            </div>
                        ";
                }
            }
        ?>
    </div>

    <script>
        $(document).ready(function (){
            $('.add_qu').on('click', function(){
                $(this).removeClass("add_qu");
                $(this).addClass("rm_qu");
                $("#addedQu").append($(this));
                console.log('okay')
            });

            $('.rm_qu').on('click', function(){
                $(this).removeClass("rm_qu");
                $(this).addClass("add_qu");
                $("#questions_list").append($(this));
                console.log("WORK");
            })
        });
    </script>
</section>