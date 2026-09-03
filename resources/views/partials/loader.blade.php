<div id="eq8-loader" class="eq8-loader" dir="rtl" aria-hidden="true">
    <div class="eq8-loader__bar"><div class="eq8-loader__bar-fill" id="eq8LoaderBarFill"></div></div>

    <div class="eq8-loader__center">
        <div class="eq8-loader__ring-wrap">
            <svg class="eq8-loader__ring" viewBox="0 0 120 120" aria-hidden="true">
                <circle class="eq8-loader__ring-track" cx="60" cy="60" r="54" fill="none" stroke-width="4"/>
                <circle class="eq8-loader__ring-arc" cx="60" cy="60" r="54" fill="none" stroke="#ffb703" stroke-width="4" stroke-linecap="round"/>
            </svg>
            <div class="eq8-loader__circle">
                <svg class="eq8-loader__bolt" width="52" height="52" viewBox="0 0 24 24" fill="#ffb703" aria-hidden="true">
                    <path d="M13 2 4 14h6l-1 8 9-12h-6l1-8z"/>
                </svg>
            </div>
        </div>

        <div class="eq8-loader__brand">⚡ ElectricQ8</div>
        <div class="eq8-loader__subtitle">جاري تحضير الموقع…</div>
        <div class="eq8-loader__percent" id="eq8LoaderPercent">0%</div>
    </div>
</div>

<style>
.eq8-loader {
    position: fixed;
    inset: 0;
    z-index: 99999;
    background-color: #1a0f08;
    background-image: radial-gradient(rgba(255,183,3,.08) 1px, transparent 1px);
    background-size: 26px 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity .4s ease;
}
.eq8-loader[hidden] { display: none; }

.eq8-loader__bar {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: rgba(255,255,255,.06);
    overflow: hidden;
}
.eq8-loader__bar-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg,#6B3A17,#ffb703);
    transition: width .18s ease;
}

.eq8-loader__center {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    font-family: 'Cairo', system-ui, sans-serif;
    text-align: center;
}

.eq8-loader__ring-wrap {
    position: relative;
    width: 120px;
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 18px;
}

.eq8-loader__ring {
    position: absolute;
    inset: 0;
    width: 120px;
    height: 120px;
    transform: rotate(-90deg);
}
.eq8-loader__ring-track { stroke: rgba(255,183,3,.12); }
.eq8-loader__ring-arc {
    stroke-dasharray: 339.292; /* 2 * PI * 54 */
    stroke-dashoffset: 339.292;
    animation: eq8-ring-spin 1.6s ease-in-out infinite;
    transform-origin: 60px 60px;
}
@keyframes eq8-ring-spin {
    0%   { stroke-dashoffset: 339.292; transform: rotate(0deg); }
    50%  { stroke-dashoffset: 84.823;  transform: rotate(240deg); }
    100% { stroke-dashoffset: 339.292; transform: rotate(720deg); }
}

.eq8-loader__circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: radial-gradient(circle, #6B3A17, #2e1a0c);
    box-shadow: 0 0 0 6px rgba(255,183,3,.12);
    display: flex;
    align-items: center;
    justify-content: center;
}

.eq8-loader__bolt {
    filter: drop-shadow(0 0 10px rgba(255,183,3,.85));
    animation: eq8-bolt-pulse 1.1s ease-in-out infinite;
}
@keyframes eq8-bolt-pulse {
    0%, 100% { transform: scale(1); }
    50%      { transform: scale(1.06); }
}

.eq8-loader__brand {
    font-weight: 800;
    color: #fff;
    font-size: 20px;
}
.eq8-loader__subtitle {
    color: #e0b489;
    font-size: 14px;
}
.eq8-loader__percent {
    color: #ffb703;
    font-weight: 800;
    font-size: 13px;
    letter-spacing: .06em;
    margin-top: 4px;
}

@media (prefers-reduced-motion: reduce) {
    .eq8-loader__ring-arc,
    .eq8-loader__bolt { animation: none !important; }
}
</style>

<script>
(function () {
    var loader = document.getElementById('eq8-loader');
    if (!loader) return;

    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function removeLoader() {
        loader.setAttribute('hidden', '');
        if (loader.parentNode) loader.parentNode.removeChild(loader);
    }

    if (reduceMotion) {
        removeLoader();
        return;
    }

    var barFill = document.getElementById('eq8LoaderBarFill');
    var percentEl = document.getElementById('eq8LoaderPercent');
    var percent = 0;
    var finishing = false;

    function setPercent(p) {
        percent = Math.min(100, p);
        if (barFill) barFill.style.width = percent + '%';
        if (percentEl) percentEl.textContent = percent + '%';
    }

    var stepInterval = setInterval(function () {
        if (finishing) return;
        // Random-stepped increments, slowing as it approaches 90 so the
        // real "load" event can take over the final stretch to 100.
        var step = percent < 60 ? (Math.random() * 10 + 5) : (Math.random() * 3 + 1);
        setPercent(Math.min(90, percent + step));
    }, 120);

    function finish() {
        if (finishing) return;
        finishing = true;
        clearInterval(stepInterval);

        var finishInterval = setInterval(function () {
            setPercent(percent + (Math.random() * 8 + 4));
            if (percent >= 100) {
                clearInterval(finishInterval);
                setTimeout(function () {
                    loader.style.opacity = '0';
                    setTimeout(removeLoader, 400);
                }, 150);
            }
        }, 40);
    }

    window.addEventListener('load', finish);

    // Safety net: never block interaction if "load" is slow to fire.
    setTimeout(finish, 6000);
})();
</script>
