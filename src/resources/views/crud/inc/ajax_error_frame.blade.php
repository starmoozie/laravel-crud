<style>
.ajax-error-frame {
    display: none;
    position: fixed;
    z-index: 1020;
    top: 0;
}
.ajax-error-frame .content {
    --width: 80vw;
    --height: 90vh;
    position: absolute;
    width: var(--width);
    height: var(--height);
    box-shadow: 0px 0px 4rem;
    transform: translate(calc((100vw - var(--width)) / 2), calc((100vh - var(--height)) / 2));
    border-radius: 0.4rem;
    background-color: #FFF;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.ajax-error-frame iframe {
    border: 0;
    height: 100%;
}
.ajax-error-frame .close {
    position: absolute;
    right: 0.8rem;
    top: 0.4rem;
    cursor: pointer;
}
.ajax-error-frame .background {
    position: absolute;
    background-color: #0002;
    width: 100vw;
    height: 100vh;
}
.ajax-error-frame.active {
    display: block;
    opacity: 0;
    animation-name: fadeIn;
    animation-duration: .4s;
    animation-fill-mode: forwards;
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
</style>

<div class="ajax-error-frame">
    <div class="background"></div>
    <div class="content">
        <div class="close">×</div>
        <iframe></iframe>
    </div>
</div>

<script>
const errorFrame = document.querySelector('.ajax-error-frame');

$(document).ajaxComplete((e, result, settings) => {
    if(result.responseJSON?.exception !== undefined) {
        $.ajax({...settings, accepts: "text/html", starmoozieExceptionHandler: true});
    }
    else if(settings.starmoozieExceptionHandler) {
        Noty.closeAll();
        errorFrame.classList.add('active');
        errorFrame.querySelector('iframe').srcdoc = result.responseText;
        errorFrame.querySelectorAll('.close, .background').forEach(e => e.onclick = () => errorFrame.classList.remove('active'));
    }
});
</script>