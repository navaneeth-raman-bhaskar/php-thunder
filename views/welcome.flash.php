@layout('app')
@title
Welcome
@endtitle
@content
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        font-size: 62.5%;
    }

    .main {
        width: 100vw;
        height: 100vh;
        background-color: #222f3e;
        display: grid;
        place-items: center;
    }

    .center {
        width: 50%;
        height: auto;
        user-select: none;
    }

    ul.thunder, h3.description {
        display: flex;
        justify-content: center;
    }

    ul.thunder {
        list-style-type: none;
    }

    li {
        font-size: 10rem;
        font-weight: bold;
        padding-left: 2rem;
        color: #576574;
        animation: light 1.3s linear infinite;
    }

    li:first-child {
        padding-left: 0rem;
    }

    @-webkit-keyframes light {
        0% {
            color: #576574;
            text-shadow: none;
        }
        90% {
            color: #576574;
            text-shadow: none;
        }
        100% {
            color: #f1c40f;
            text-shadow: 0 0 1rem #d35400, 0 0 7rem #d35400;
        }
    }

    .center ul li:nth-child(1) {
        animation-delay: 0s;
    }

    .center ul li:nth-child(2) {
        animation-delay: 0.1s;
    }

    .center ul li:nth-child(3) {
        animation-delay: 0.2s;
    }

    .center ul li:nth-child(4) {
        animation-delay: 0.3s;
    }

    .center ul li:nth-child(5) {
        animation-delay: 0.4s;
    }

    .center ul li:nth-child(6) {
        animation-delay: 0.5s;
    }

    .center ul li:nth-child(7) {
        animation-delay: 0.6s;
    }

    a.no-style {
        text-decoration: none;
        color: white;
    }

</style>
<div class="main">
    <div class="center">
        <ul class="thunder">
            <li>T</li>
            <li>H</li>
            <li>U</li>
            <li>N</li>
            <li>D</li>
            <li>E</li>
            <li>R</li>
        </ul>
        <h3 class="description">
            <a class="no-style" href="https://github.com/navaneeth-raman-bhaskar/php-thunder">
                Lightning fast PHP framework
            </a>
        </h3>
    </div>
</div>
@endcontent