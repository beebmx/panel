<template>
    <panel-field v-bind="$props" class="is-date-field">
        <label class="label" :for="id">
            <span v-text="label"></span>
            <abbr v-if="required" title="Required">*</abbr>
        </label>
        <div class="control" :class="{'has-icons-right':icon}">
            <input type="text" class="input" icon="calendar" @keyup.esc="close" @blur="close" @click="toggle" v-model="data">
            <span v-if="icon" class="icon is-small is-right">
                <panel-icon :icon="icon" />
            </span>
        </div>
        <div class="datepicker" :class="{ 'is-active': isActive, 'is-right' : isRight }">
            <div class="calendar">
                <div class="calendar-nav">
                    <div class="calendar-nav-left">
                        <button class="button is-text" @mousedown.prevent="preventBlur" @click="prevYear">
                            <i class="fa fa-backward"></i>
                        </button>
                        <button class="button is-text" @mousedown.prevent="preventBlur" @click="prevMonth">
                            <i class="fa fa-chevron-left"></i>
                        </button>
                    </div>
                    <div> <span v-text="formattedMonth"></span> <span v-text="currentYear"></span> </div>
                    <div class="calendar-nav-right">
                        <button class="button is-text" @mousedown.prevent="preventBlur" @click="nextMonth">
                            <i class="fa fa-chevron-right"></i>
                        </button>
                        <button class="button is-text" @mousedown.prevent="preventBlur" @click="nextYear">
                            <i class="fa fa-forward"></i>
                        </button>
                    </div>
                </div>
                <div class="calendar-container">
                    <div class="calendar-header">
                        <div class="calendar-date" v-for="day in weekdays" :key="day">{{ day }}</div>
                    </div>
                    <div class="calendar-body">
                        <div class="calendar-date" :class="{ 'is-disabled': item.isDisabled }" v-for="(item, i) in renderDays()" :key="i">
                            <button class="date-item" :class="{ 'is-today': item.isToday, 'is-active' : item.isSelected }" :disabled="item.isDisabled" @mousedown.prevent="preventBlur" @click="select(item.date)">{{ item.day }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p v-if="error" class="help is-danger" v-text="error"></p>
        <p v-if="help" class="help" v-text="help"></p>
    </panel-field>
</template>

<script>
import field from '../props/field'
import input from '../props/input'
import moment from 'moment'

export default {
    mixins: [field, input],
    props: {
        icon: {
            default: 'calendar'
        },
    },
    data () {
        return {
            data: this.value,
            current: moment(),
            dateFormat: 'YYYY-MM-DD',
            isActive : false,
            dateSelected : moment(this.value),
            formattedMonth : null,
            currentYear : null,
            currentMonth : null,
        }
    },
    created() {
        this.adjustCalendar()
    },
    computed : {
        weekdays(){
            return moment.weekdaysShort()
        },
        months(){
            return moment.months()
        },
        isRight(){
            return this.align === 'right'
        }
    },
    methods:{
        daysInMonth(){
            return this.current.daysInMonth()
        },
        firstOfMonth(){
            return this.current.startOf('month').day()
        },
        prevMonth(){
            this.current = this.current.subtract(1,'M')
            this.adjustCalendar()
        },
        nextMonth(){
            this.current = this.current.add(1,'M')
            this.adjustCalendar()
        },
        prevYear(){
            this.current = this.current.subtract(1,'y')
            this.adjustCalendar()
        },
        nextYear(){
            this.current = this.current.add(1,'y')
            this.adjustCalendar()
        },
        adjustCalendar(){
            this.formattedMonth = this.current.format('MMMM')
            this.currentYear = this.current.get('year')
            this.currentMonth = this.current.get('month')
        },
        renderDays(){
            let days = this.daysInMonth(), before = this.firstOfMonth(), cells = days + before, after = cells
            let renderedDays = [], now = moment().startOf('day')
            while (after > 7) {
                after -= 7;
            }
            cells += 7 - after;
            
            for (let i=0; i<cells; i++){
                let date = moment( new Date(this.currentYear, this.currentMonth, 1 + (i-before) ) )
                renderedDays.push ({
                    date: date,
                    day: date.date(),
                    isToday :  ( date.diff(now, 'days') === 0 ) ? true : false,
                    isDisabled : ( date.get('month') !== this.currentMonth ) ? true : false,
                    isSelected : ( date.diff(moment(this.dateSelected).startOf('day'), 'days') === 0 ) ? true : false,
                    });
            }
            return renderedDays
        },
        toggle(){
            this.isActive = !this.isActive
        },
        close() {
            this.isActive = false
        },
        select(date){
            this.dateSelected = date
            this.$emit( 'input', { id:this.id, value: moment(this.dateSelected).format(this.dateFormat) } )
            this.close()
        },
        preventBlur (){
            return
        }
    },
    watch: {
        value(value) {
            this.data = value
            this.dateSelected = moment(value)
            this.current = (value) ? moment(value) : moment()
            this.adjustCalendar()
        },
        data() {
            this.$emit('input', {id:this.id, value:this.data})
        }
    }
}
</script>
