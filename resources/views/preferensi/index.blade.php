@extends('layouts.app')

@section('title', 'Pengaturan - SummitBuddy')

@section('content')
<div style="max-width:600px;margin:0 auto">
    <div style="background:#fff;border-radius:20px;padding:30px">
        <h2>Pengaturan Tampilan</h2>

        <div style="margin-bottom:30px">
            <label style="display:block;font-weight:600;margin-bottom:15px;color:#1b5e2f">Tema</label>
            <div style="display:flex;gap:15px">
                <button class="theme" data-theme="light">☀️ Light</button>
                <button class="theme" data-theme="dark">🌙 Dark</button>
                <button class="theme" data-theme="system">💻 System</button>
            </div>
        </div>

        <div style="margin-bottom:30px">
            <label style="display:block;font-weight:600;margin-bottom:15px;color:#1b5e2f">Ukuran Font</label>
            <div style="display:flex;gap:15px">
                <button class="font" data-font="small">A Kecil</button>
                <button class="font" data-font="medium">A Sedang</button>
                <button class="font" data-font="large">A Besar</button>
            </div>
        </div>

        <button id="save" style="background:#1b5e2f;color:#fff;border:none;padding:12px;border-radius:50px;width:100%;cursor:pointer">Simpan</button>
        <div id="msg" style="margin-top:20px;padding:10px;border-radius:10px;text-align:center;display:none"></div>
    </div>
</div>

<style>
.dark .theme-btn,.dark .font-btn,.dark div[style*="background:#fff"]{background:#2d2d44!important;color:#eee!important}
.theme,.font{padding:12px 24px;border:2px solid #ddd;background:#fff;border-radius:50px;cursor:pointer}
.theme.active,.font.active{background:#1b5e2f!important;color:#fff!important;border-color:#1b5e2f}
</style>

<script>
const CSRF=document.querySelector('meta[name="csrf-token"]').content;
let tema='light',font='medium';

function setCookie(n,v){document.cookie=`${n}=${v};expires=${new Date(Date.now()+31536e6).toUTCString()};path=/`}
function applyTheme(t){let dark=t==='dark'||(t==='system'&&matchMedia('(prefers-color-scheme:dark)').matches);document.documentElement.classList.toggle('dark',dark);document.querySelectorAll('.theme').forEach(b=>b.classList.toggle('active',b.dataset.theme===t))}
function applyFont(f){document.body.className=document.body.className.replace(/font-\S+/g,'');document.body.classList.add(`font-${f}`);document.querySelectorAll('.font').forEach(b=>b.classList.toggle('active',b.dataset.font===f))}

document.querySelectorAll('.theme').forEach(b=>b.onclick=()=>{tema=b.dataset.theme;applyTheme(tema)});
document.querySelectorAll('.font').forEach(b=>b.onclick=()=>{font=b.dataset.font;applyFont(font)});
document.getElementById('save').onclick=async()=>{let r=await fetch('/api/preferensi',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},body:JSON.stringify({tema,font_size:font})}),d=await r.json();if(d.success){setCookie('preferensi_tema',tema);setCookie('preferensi_font_size',font);let m=document.getElementById('msg');m.textContent='✅ Disimpan!';m.style.display='block';m.style.background='#d4edda';m.style.color='#155724';setTimeout(()=>m.style.display='none',2000)}};
</script>
@endsection
