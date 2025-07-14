<style>
    #sidebar {
        position: absolute;
        width: 240px;
        height: 1138px;
        left: 0px;
        top: 0px;

        /* Colors / White / 100% */

        background: #FFFFFF;
    }

    #brand {
        position: absolute;
        width: 240px;
        height: 1024px;
        left: 0px;
        top: 0px;

        /* Colors / White / 100% */

        background: #FFFFFF;
    }

    #side-menu {
        position: absolute;
        width: 240px;
        height: 1024px;
        left: 0px;
        top: 0px;

        /* Colors / White / 100% */

        background: #FFFFFF;
    }
    #side-menu button {
        position: absolute;
        left: 0%;
        right: 0%;
        top: 0%;
        bottom: 0%;

        /* colors/brand/primary-darker */

        background: #329FBA;
        box-shadow: 0px 10px 20px rgba(13, 102, 124, 0.2);
        border-radius: 12px;
    }
</style>

<div id="sidebar">
    <div id="brand">
        <img src=" {{ asset("images/brand.svg") }}" alt="">
    </div>

    <div id="side-menu">
        <button>
                testando
        </button>
    </div>
</div>