

document.addEventListener('alpine:init', () => {
    Alpine.data('dropdown', () => ({
        open: false,
        textValue: "",
        values:[],
        valuesFiltered:[],
        Selected: [],
        inputForm :null,
        initValues(data,selectedValues){
            this.Selected = selectedValues
          this.values = data;
            this.inputForm = document.getElementById("multi-selected-json");
            this.inputForm.value=this.Selected;
        },
        toggle(e) {
            if(e.pointerType === "mouse")
            {
                this.open = ! this.open
            }
        },
        remove(e)
        {
          console.log(e)
        },
        OnClickDropDown( )
        {
            this.valuesFiltered = [];

            if(this.values !== "" && this.textValue.length >2)
            {
                this.valuesFiltered =[];
                this.valuesFiltered = Object.fromEntries(Object.entries(this.values).filter(([key,value]) => value['label'].toLowerCase().includes(this.textValue)));
                return JSON.parse(JSON.stringify(this.valuesFiltered));
            }
            else{
                return JSON.parse(JSON.stringify(this.values));
            }

        },
        DrawSelected(){
            let valuesFiltered = [];
            valuesFiltered = this.Selected.map((value) => ({ id : value , value : this.values[value].label}));
            return valuesFiltered;
        },
        removeFromSelect(code)
        {
            this.values[code]['selected'] = false;
            this.Selected = this.Selected.filter((value) => (value !== code))
            this.inputForm.value=this.Selected;
        },
        switchSelected(code)
        {
            let intCode = parseInt(code);
            if(this.Selected.includes(intCode))
            {
                this.removeFromSelect(intCode);
            }
            else
            {
                this.values[code]['selected'] = true;
                this.Selected.push(intCode);
            }
            this.inputForm.value=this.Selected;
        }

    }))
})
