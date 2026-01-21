initMap();

async function initMap() {
  await ymaps3.ready;

  const {
    YMap,
    YMapDefaultSchemeLayer,
    YMapDefaultFeaturesLayer,
    YMapMarker
  } = ymaps3;

  const center = [44.886192, 53.233468];

  const mapEl = document.getElementById('map');

  const map = new YMap(mapEl, {
    location: { center, zoom: 14 }
  });

  map.addChild(new YMapDefaultSchemeLayer());
  map.addChild(new YMapDefaultFeaturesLayer());

  const markerEl = document.createElement('div');
  markerEl.className = 'y-pin';
  markerEl.style.transform = 'translate(-50%, -100%)';
  markerEl.innerHTML = `
    <div class="y-pin__popup" hidden>
      <div class="y-pin__title">Академия успеха</div>
      <div class="y-pin__text">г. Пенза, ул. 65-летия Победы, 29
(1 этаж)</div>
    </div>

    <svg class="y-pin__icon" width="34" height="42" viewBox="0 0 34 42" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <path d="M17 0C7.6 0 0 7.6 0 17c0 12.2 17 25 17 25s17-12.8 17-25C34 7.6 26.4 0 17 0z" fill="#E53935"/>
      <circle cx="17" cy="17" r="6.5" fill="#fff"/>
    </svg>
  `;

  const popup = markerEl.querySelector('.y-pin__popup');

  markerEl.addEventListener('click', (e) => {
    e.stopPropagation();
    popup.hidden = !popup.hidden;
  });

  mapEl.addEventListener('click', () => {
    popup.hidden = true;
  });

  map.addChild(new YMapMarker({ coordinates: center }, markerEl));
}
