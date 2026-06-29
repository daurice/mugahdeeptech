(function () {
  var menu=document.querySelector('.kids-menu'),links=document.querySelector('.kids-links');
  if(menu&&links)menu.addEventListener('click',function(){var open=links.classList.toggle('open');menu.setAttribute('aria-expanded',String(open));});
  var observer='IntersectionObserver' in window?new IntersectionObserver(function(entries){entries.forEach(function(entry){if(entry.isIntersecting){entry.target.style.transitionDelay=(entry.target.dataset.delay||0)+'ms';entry.target.classList.add('visible');observer.unobserve(entry.target);}});},{threshold:.12}):null;
  document.querySelectorAll('.reveal').forEach(function(el){if(observer)observer.observe(el);else el.classList.add('visible');});
  var narrator=document.querySelector('.narrate-btn');
  if(narrator)narrator.addEventListener('click',function(){if(!('speechSynthesis' in window))return toast('Narration is not available in this browser.');speechSynthesis.cancel();var u=new SpeechSynthesisUtterance(narrator.dataset.narration||'Let us learn together.');u.rate=.9;u.pitch=1.08;speechSynthesis.speak(u);toast('Narration started 🔊');});
  document.querySelectorAll('.flashcard').forEach(function(card){card.addEventListener('click',function(){card.classList.toggle('flipped');if(document.querySelectorAll('.flashcard.flipped').length===document.querySelectorAll('.flashcard').length)success();});});
  var dragged=null;
  document.querySelectorAll('[draggable=true]').forEach(function(el){el.addEventListener('dragstart',function(){dragged=el;});});
  document.querySelectorAll('[data-target]').forEach(function(target){target.addEventListener('dragover',function(e){e.preventDefault();});target.addEventListener('drop',function(e){e.preventDefault();if(dragged&&dragged.dataset.match===target.dataset.target){target.classList.add('correct');target.querySelector('span').textContent=dragged.textContent;dragged.remove();if(!document.querySelector('[data-match]'))success();}else toast('Almost! Try a different match 🌱');});});
  var codeDrop=document.querySelector('[data-code-drop]');
  if(codeDrop){codeDrop.addEventListener('dragover',function(e){e.preventDefault();});codeDrop.addEventListener('drop',function(e){e.preventDefault();if(dragged){var b=document.createElement('button');b.type='button';b.textContent=dragged.textContent;codeDrop.appendChild(b);dragged.remove();}});}
  var run=document.querySelector('.run-code');
  if(run)run.addEventListener('click',function(){var game=run.closest('.coding-game'),solution=JSON.parse(game.dataset.solution||'[]'),chosen=Array.from(game.querySelectorAll('.code-sequence button')).map(function(b){return b.textContent;});if(JSON.stringify(solution)===JSON.stringify(chosen)){game.querySelector('.mini-robo').classList.add('run');setTimeout(success,1400);}else toast('Debug time! Check the command order 🧩');});
  function success(){var modal=document.querySelector('.activity-success');if(modal){modal.classList.add('show');confetti();}}
  function toast(message){var el=document.querySelector('.kids-toast');if(!el)return;el.textContent=message;el.classList.add('show');setTimeout(function(){el.classList.remove('show');},2400);}
  function confetti(){for(var i=0;i<28;i++){let p=document.createElement('i');p.style.cssText='position:fixed;z-index:250;top:-20px;left:'+Math.random()*100+'vw;width:9px;height:14px;background:'+['#6757f5','#ffd85a','#36c98f','#ff729f'][i%4]+';animation:confettiFall 2.5s '+Math.random()*.5+'s forwards';document.body.appendChild(p);setTimeout(function(){p.remove();},3200);}}
  var style=document.createElement('style');style.textContent='@keyframes confettiFall{to{transform:translateY(105vh) rotate(600deg);opacity:0}}';document.head.appendChild(style);
})();
