<template>
    <nav class="pagination is-centered" :class="size" role="navigation" aria-label="pagination">
        <button class="pagination-previous"
          :disabled="onFirstPage"
          @click="update(current - 1)">Anterior</button>
        <button class="pagination-next"
          :disabled="!hasMorePages"
          @click="update(current + 1)">Siguiente</button>
        <ul class="pagination-list">
            <li><button v-if="start >= 2"
                   class="pagination-link is-start"
                   v-text="1"
                   @click="update(1)"></button></li>
            <li><span v-if="start > 2" class="pagination-ellipsis">&hellip;</span></li>

            <li v-for="(page, index) in displayPages" :key="index">
                <button class="pagination-link"
                   :class="{'is-current':isCurrent(page)}"
                   v-text="page"
                   @click="update(page)"></button>
            </li>

            <li><span v-if="end < pages - 1" class="pagination-ellipsis">&hellip;</span></li>
            <li><button v-if="end <= pages - 1"
                   class="pagination-link is-end"
                   v-text="pages"
                   @click="update(pages)"></button></li>
        </ul>
    </nav>
</template>
    
<script>
import { mapGetters } from 'vuex'
export default {
    props: {
        size: {
            type: String,
            default: ''
        }
    },
    computed: {
        ...mapGetters({
            pagination: 'model/getPagination'
        }),
        current() {
            return this.pagination.current_page
        },
        last() {
            return this.pagination.last_page
        },
        total() {
            return this.pagination.total
        },
        range() {
            return this.pagination.per_page
        },
        onFirstPage() {
            return this.current === 1
        },
        hasMorePages() {
            return this.current < this.last
        },
        limits() {
            let start = this.current - this.block;
            let end = this.current + this.block;

            if (end > this.pages) {
                end = this.pages
                start = start < 1 ? 1 : (this.pages - this.block * 2)
            }
            if (start <= 1) {
                start = 1;
                end = Math.min(this.block * 2 + 1, this.pages);
            }
            
            return {start, end}
            
        },
        start() {
            return {...this.limits}['start'];
        },
        end() {
            return {...this.limits}['end'];
        },
        displayPages() {
            const {start, end} = {...this.limits};
            let display = [];

            for (let i = start; i <= end; i++ ) {
                display.push(i)
            }
            return display
        },
        pages() {
            return Math.ceil(this.total / this.range);
        }
    },
    data () {
        return {
            block: 2
        }
    },
    methods: {
        isCurrent(page) {
            return !!(page === this.current);
        },
        update(page) {
            if (page !== this.current) {
                this.$emit('update',page)
            }
        }
    }
}
</script>