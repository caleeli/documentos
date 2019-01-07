<template>
    <canvas class="jdd-drawing-box" @mousedown="handleMouseDown" @mouseup="handleMouseUp" @mousemove="handleMouseMove"
            @touchstart="handleMouseDown" @touchend="handleMouseUp" @touchmove="handleMouseMove"
            width="320px" height="160px"></canvas>
</template>

<script>
    export default {
        data: function() {
            return {
                mouse: {
                    current: {
                        x: 0,
                        y: 0
                    },
                    previous: {
                        x: 0,
                        y: 0
                    },
                    down: false
                }
            }
        },
        computed: {
            currentMouse: function() {
                var rect = this.$el.getBoundingClientRect();

                return {
                    x: this.mouse.current.x - rect.left,
                    y: this.mouse.current.y - rect.top
                }
            }
        },
        methods: {
            draw: function(event) {


                // requestAnimationFrame(this.draw);
                if (this.mouse.down) {

                    var ctx = this.$el.getContext("2d");

                    ctx.clearRect(0, 0, 800, 800);


                    ctx.lineTo(this.currentMouse.x, this.currentMouse.y);
                    ctx.strokeStyle = "#F63E02";
                    ctx.lineWidth = 2;
                    ctx.stroke();
                    this.$emit('input', this.$el.toDataURL());
                }

            },
            handleMouseDown: function(event) {
                this.mouse.down = true;
                this.updatePointerPosition(event);

                var ctx = this.$el.getContext("2d");

                ctx.moveTo(this.currentMouse.x, this.currentMouse.y)


            },
            handleMouseUp: function(event) {
                this.mouse.down = false;
            },
            handleMouseMove: function(event) {
                this.updatePointerPosition(event);
                this.draw(event);
                event.preventDefault();

            },
            updatePointerPosition: function(event) {
                if (event.changedTouches) {
                    this.mouse.current = {
                        x: event.changedTouches[0].pageX,
                        y: event.changedTouches[0].pageY
                    }
                } else {
                    this.mouse.current = {
                        x: event.pageX,
                        y: event.pageY
                    }
                }
            }
        },
        ready: function() {

            var ctx = this.$el.getContext("2d");
            ctx.translate(0.5, 0.5);
            ctx.imageSmoothingEnabled = false;
        }
    };
</script>

<style lang="scss" scoped>
    .jdd-drawing-box{
        border-bottom: 1px solid black;
    }
</style>
