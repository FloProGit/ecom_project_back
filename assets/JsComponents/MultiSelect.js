

document.addEventListener('alpine:init', () => {
    Alpine.data('dropdown', () => ({
        open: false,
        values:[],
        initValues(data){
          this.values = data;
        },
        toggle() {
            this.open = ! this.open
        },

    }))
})