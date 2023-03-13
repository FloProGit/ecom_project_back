

document.addEventListener('alpine:init', () => {
    Alpine.data('dropdown', () => ({
        open: false,
        textValue: "",
        values:[],
        valuesFiltered:[],
        initValues(data){
          this.values = data;
        },
        toggle(e) {
            if(e.pointerType === "mouse")
            {
                this.open = ! this.open
            }
        },
        clear(el)
        {
            console.log(el)
        },
        getKeyDown( )
        {
            this.valuesFiltered = [];

            if(this.values !== "" && this.textValue.length >2)
            {
                this.valuesFiltered =[];
                this.valuesFiltered = Object.fromEntries(Object.entries(this.values).filter(([key,value]) => value.toLowerCase().includes(this.textValue)));
                console.log(this.valuesFiltered);
                return JSON.parse(JSON.stringify(this.valuesFiltered));
            }
            else{
                console.log('je pass ici')
                return JSON.parse(JSON.stringify(this.values));
            }

        }


    }))
})
