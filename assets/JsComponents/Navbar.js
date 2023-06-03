document.addEventListener('alpine:init', () => {
    Alpine.data('navbar', () => ({
        firstMenu: '',
        subMenu: '',
        initValues(data){
            this.firstMenu = data['fm'];
            this.subMenu = data['sm'];
           console.log(data)
        },
    }))
});