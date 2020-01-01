var members = document.getElementById('members');

var param = new URLSearchParams(location.search);

var clientId = 'c9kjxs4tawdkqnnpg2lpzkraceam6g';

var xhttp = new XMLHttpRequest();

function initialize() {
    xhttp.addEventListener('load', initializeMembers);
    xhttp.open('GET', 'https://api.twitch.tv/kraken/teams/tsaph');
    xhttp.setRequestHeader('Client-ID', clientId);
    xhttp.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json');
    xhttp.send();
}

function initializeMembers() {
    memList = JSON.parse(xhttp.responseText);
    memLength = memList.users.length;

    memList.users.forEach(function (member, index, array) {
        memberItem = document.createElement('li');
        ahref = document.createElement('a');
        img = document.createElement('img');
        img.src = member.logo;
        ahref.href = member.url;
        ahref.innerHTML = member.display_name;
        memberItem.appendChild(ahref);
        ahref.insertBefore(img, ahref.firstChild);
        members.appendChild(memberItem);
    });
}

function searchMembers() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    ul = document.getElementById("members");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

initialize();
