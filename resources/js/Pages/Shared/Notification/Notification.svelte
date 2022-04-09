<script>

    export let notification = false
  
    let renk
  
    switch (notification.type) {
  
      default:
      case "success":
        renk = 'is-success'
        break;
  
      case "info":
        renk = 'is-info'
        break;
  
      case "warning":
        renk = 'is-warning'
        break;
  
      case "danger":
        renk = 'is-danger'
        break;
  
      case "success":
        renk = 'is-success'
        break;
    }
</script>
    
  
{#if notification}
    <div class="notification {renk} is-light">
        {notification.message}
    </div>
{/if}
  