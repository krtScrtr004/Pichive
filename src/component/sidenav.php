<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .side_nav {
        width: 20%;
        background-color: black;
        color: white;
        position: sticky;
        top: 0;
        display: flex;
        flex-direction: column;
    }

    .upper_halve, .lower_halve {
        flex: 1;
        overflow: auto hidden;
    }
</style>

<aside class="side_nav">
    <section class="upper_halve">
        <h2>Upper Half</h2>
        <ul>
            <li><a href="#">Link 1</a></li>
            <li><a href="#">Link 2</a></li>
            <li><a href="#">Link 3</a></li>
        </ul>
    </section>
    <section class="lower_halve">
    <h2>Lower Half</h2>
        <ul>
            <li><a href="#">Link 1</a></li>
            <li><a href="#">Link 2</a></li>
            <li><a href="#">Link 3</a></li>
        </ul>
    </section>
</aside>