<nav id="navigation" class="navbar navbar-expand-lg navbar-light bg-white shadow rounded-bottom">
        <span class="navbar-brand" href="#">
            <h3>
                <img src="<?=DOMAIN;?>/img/logo.png" width="50" height="50" alt="EspressoLIGHT">
                <i class="px-3">Espresso <sub><small>light</small></sub></i>
            </h3>
        </span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul id="nav-controls" class="navbar-nav mr-auto">
            <?if(!API_Auth::isEmployee()){?>
                <li class="nav-item">
                    <a data-route="accounts" class="nav-link" href="/accounts<?if(API_Auth::isOwner()){echo '/'.API_Auth::getProp('account_id');}?>"><h5>Аккаунт<?if(API_Auth::isMaster()){echo 'ы';}?></h5></a>
                </li>
            <?}?>
            <li class="nav-item">
                <a data-route="users" class="nav-link" href="/users"><h5>Сотрудники</h5></a>
            </li>
            <li class="nav-item">
                <a data-route="other" class="nav-link" href="/other"><h5>Другое</h5></a>
            </li>
        </ul>
        <div class="px-3 text-muted">
            <a href=""><?=API_Auth::getProp('user_full_name');?></a>
        </div>
        <form method="POST" class="form-inline my-2 my-lg-0" onsubmit="return false;">
            <input id="logout" class="btn btn-outline-secondary my-2 my-sm-0" type="submit" value="Выход">
            <input type="hidden" name="logout" value="1">
        </form>
    </div>
</nav>
