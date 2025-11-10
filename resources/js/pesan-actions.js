// Simple helper to start/find conversation and redirect to /pesan?conv={id}
window.startConversation = function(targetUserId) {
  const tokenMeta = document.querySelector('meta[name="csrf-token"]');
  const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

  // show loading / disable UX here if needed
  fetch('/pesan/conversations', {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': token
    },
    body: JSON.stringify({ user_id: targetUserId })
  }).then(async (res) => {
    if (!res.ok) {
      // try parse message
      let msg = 'Gagal membuat percakapan';
      try { const j = await res.json(); if (j.message) msg = j.message; } catch(e){}
      alert(msg);
      return;
    }
    const data = await res.json();
    if (data.conversation && data.conversation.id) {
      // redirect and open conversation
      window.location.href = `/pesan?conv=${data.conversation.id}`;
    } else {
      window.location.href = '/pesan';
    }
  }).catch(err => {
    console.error(err);
    window.location.href = '/pesan';
  });
};
