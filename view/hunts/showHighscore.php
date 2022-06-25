<link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("scores.css") ?>">
<section class="scoreboard">
    <h2><?php echo $hunt->getHunt_Title() ?> - scores</h2>
    <div id="boardguide">
        <p>victoire</p>
        <p>utilisateur</p>
        <p>score</p>
        <p>temps</p>
        <p>date</p>
    </div>
        <?php
            if (isset($scores)){
                foreach ($scores as $attempt){
                        if($attempt->getWin())
                            $win = "<i class='fa-solid fa-trophy win'></i>";
                        else
                            $win = "<i class='fa-solid fa-trophy lose'></i>";
                        echo "
                                <div class='ls_item' data-atid='".$attempt->getAttempt_id()."'>
                                    <div class='win' data-atwin='".$attempt->getWin()."'>
                                        ".$win."
                                    </div>
                                    <div class='username'>
                                        ".$attempt->getUserName($attempt)."
                                    </div>
                                    <div class='score'>
                                        ".$attempt->getScore()."
                                    </div>
                                    <div class='time'>
                                        ".$attempt->getAttempt_time()."
                                    </div>
                                    <div class='date'>
                                        ".$attempt->getAttempt_date()."
                                    </div>
                                </div>
                            ";
                }
            }
        ?>
    <script>
        /*$('.win').each(function (){
            if($(this).data('atwin'))
                $(this).append("<i class='fa-solid fa-trophy win'></i>");
            else
                $(this).append("<i class='fa-solid fa-trophy lose'></i>");

        });*/
    </script>
</section>






