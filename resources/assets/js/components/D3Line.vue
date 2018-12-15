<template>
    <div style="height: 100%"></div>
</template>
<script>
    import * as d3 from 'd3';
    const data = [99, 71, 78, 25, 36, 92];
    export default {
        mounted() {
            const $el = $(this.$el);
            const width = this.$el.offsetWidth, height = this.$el.offsetHeight;
            const svg = d3.select(this.$el)
                    .append('svg')
                    .attr('width', width)
                    .attr('height', height)
                    .append('g')
                    .attr('transform', 'translate(0, 10)');
            const x = d3.scaleLinear().range([0, width]);
            const y = d3.scaleLinear().range([height, 0]);
            d3.axisLeft().scale(x);
            d3.axisTop().scale(y);
            x.domain(d3.extent(data, (d, i) => i));
            y.domain([0, d3.max(data, d => d)]);
            const createPath = d3.line()
                    .x((d, i) => x(i))
                    .y(d => y(d));
            svg.append('path').attr('d', createPath(data));
        },
    };
</script>

<style>
    svg path {
        fill: none;
        stroke: #76BF8A;
        stroke-width: 3px;
    }
</style>
