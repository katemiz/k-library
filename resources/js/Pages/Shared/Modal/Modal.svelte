<script>

    export let isactive
    export let props

    /*
    props = {
        title:"Modal Ttitle Here",
        commands:{
            submit:"Save Changes",
            cancel:"Cancel"
        },
        content:{
            
        }
    }
    */

    function closeModal() {
        isactive = false
    }
</script>




<div class="modal" class:is-active="{isactive}">
    <div class="modal-background" on:click="{closeModal}"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">{props.title}</p>
        <button class="delete" aria-label="close"  on:click="{closeModal}"></button>
      </header>
      <section class="modal-card-body">
       {props.content}
      </section>
      <footer class="modal-card-foot">
        <button class="button is-success">{props.commands.submit}</button>
        <button class="button" on:click="{closeModal}">{props.commands.cancel}</button>
      </footer>
    </div>
</div>