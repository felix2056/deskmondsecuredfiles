<template>
    <div>
        <div id="content">
            <article id="feedback-annotation">
                <p>
                    {{  contentText }}
                </p>
            </article>
        </div>
    </div>
</template>

<script>
export default {
    props: ['contentText'],
    
    mounted() {
        $( document ).ready( function() {
            var app = new annotator.App();
            app.include(annotator.ui.main, {element: document.querySelector('#feedback-annotation')});
            app.include(window.paragraphUi);
            // app.include(annotator.storage.http,  {
            //     prefix: 'http://example.com/api'
            // });
            app.include(function (registry) {
                return {
                createFromParagraph: function (p) {
                    alert(p.textContent);
                }
                };
            });
            app.start();
        });
    }
};
</script>

<style>
.my-span-class:hover {
    outline: 1px solid black;
}
.annotated {
    font-weight: bold;
}
</style>
