<?php
if (!is_null($user))
{
    if (is_object($user)) {
        $user_role = get_object_vars($user);
        if(!empty($user_role['role'] == 'ROLE_ADMIN'))
        { ?>
            <div class="row">
                <div class="title">
                    <h1><?php echo $user_role['name']?></h1>
                </div>
                <div class="profile">
                    <img src="images/profile.jpg" width="350px" alt="Photo" title="Photo">
                </div>
                <div class="about-me">
                    <p>Меня зовут Юра, мне 22 года.</p>
                    <p>На данном этапе являюсь начинающим веб-программистом и это мой первый адекватный сайт.</p>
                    <p>По образованию я инженер-строитель. Закончил Сумской Строительный Колледж по специальности
                        «Строительство зданий и сооружений» Бакалавр.</p>
                    <p>Всё свободное время сейчас посвящаю саморазвитию, изучению Немецкого языка и Английского языка,
                        также благодаря курсам в Вашей компании теперь работаю над данным приложением.</p>
                    <p>Всегда тянуло что-то создавать и воплощать в жизнь, но не было определённого толчка.
                        Работал инженером в компании «Сумбуд», так же работал полтора года в компании «Фокстрот» в Call – центре,
                        где добился больших успехов, до этого не работая в продажах.</p>
                    <p>Пробовал себя в разных направлениях, но всеравно возвращался к тому, что хочется создавать и творить.
                        И вот в середине Апреля увидел резюме Вашей компании в интернете, и загорелся желанием начать
                        заниматься в жизни тем, что приносит действительно удовольствие от того что делаешь.</p>
                    <p>Днём и ночью изучаю сейчас всю возможную информацию по написанию сайта с нуля. Так как это мой первый сайт,
                        то осталось очень много вопросов и идей. Которые хотелось бы воплощать и учиться, учиться и ещё
                        раз учиться чему-то новому.</p><br />
                    <a class="logo-twitter" href="https://twitter.com/jurazubach">
                        <img src="/images/logo_twitter.png" width="30px"></a>
                </div>
            </div>
        <?php } else { ?>
            <div class="title">
                <h1><?php echo $user_role['name']?></h1>
            </div>
            <div class="profile">
                <img src="images/guest.png" width="250px" alt="Photo" title="Photo">
            </div>
            <div class="about-me">
                <p>Я обычный гость в этом мире :)</p>
            </div>
            <?php

        }
         ?>
        <?php
    }
} ?>