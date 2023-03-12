

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
        getKeyDown(array ,el)
        {
            this.valuesFiltered = array;

            if(this.values !== "" && this.textValue.length >2)
            {
                let lis = el.getElementsByTagName("li")
                console.log(lis);
                for(let i = 0, il = lis.length;i<il;i++) {
                    if(lis[i])
                    {
                        lis[i].remove();
                    }
                }
                this.valuesFiltered =[];
                this.valuesFiltered = Object.fromEntries(Object.entries(array).filter(([key,value]) => value.toLowerCase().includes(this.textValue)));
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