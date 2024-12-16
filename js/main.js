let searchResult = document.querySelector("#search");

function createResultCard(data) {
  const resultCardTag = document.createElement("div");
  const wordResultTag = document.createElement("p");
  const pronunciationTag = document.createElement("p");
  const soundClipTag = document.createElement("audio");
  const audioSource = document.createElement("source");
  const partOfSpeechTag = document.createElement("p");
  const definitionTag = document.createElement("p");
  const exampleTag = document.createElement("p");
  const saveButton = document.createElement("button");
  resultCardTag.setAttribute("id", "result-card");
  wordResultTag.setAttribute("id", "word-result");
  pronunciationTag.setAttribute("id", "pronunciation");
  soundClipTag.setAttribute("controls", "");
  partOfSpeechTag.setAttribute("class", "part-of-speech");
  definitionTag.setAttribute("class", "definition");
  exampleTag.setAttribute("class", "example");
  saveButton.setAttribute("id", "save-button");

  data.then((item) => {
    const wordResultText = document.createTextNode(`${item.word}`);
    const pronunciation = document.createTextNode(`${item.phonetic}`);
    audioSource.setAttribute("src", `${item.audio}`);
    audioSource.setAttribute("type", "audio/mpeg");

    for (var key in item.definition) {
      if (item.definition[key].partOfSpeech !== undefined) {
        const partOfSpeech = document.createTextNode(
          `${item.definition[key].partOfSpeech}`,
        );
        partOfSpeechTag.appendChild(partOfSpeech);
      } else if (item.definition[key].example !== undefined) {
        const example = document.createTextNode(
          `${item.definition[key].example}`,
        );
        exampleTag.appendChild(example);
      } else {
        const definition = document.createTextNode(
          `${item.definition[key].definition}`,
        );
        soundClipTag.appendChild(audioSource);
        wordResultTag.appendChild(wordResultText);
        pronunciationTag.appendChild(pronunciation);
        definitionTag.appendChild(definition);
        resultCardTag.appendChild(wordResultTag);
        resultCardTag.appendChild(pronunciationTag);
        resultCardTag.appendChild(soundClipTag);
        resultCardTag.appendChild(definitionTag);
      }
    }

    const saveButtonText = document.createTextNode("Save");
    saveButton.appendChild(saveButtonText);
    resultCardTag.appendChild(saveButton);
    document.querySelector("#search-result").appendChild(resultCardTag);
  });
}

function clearResult() {
  if (searchResult.value === "") {
    if (document.querySelector("#result-card") !== null) {
      document.querySelector("#result-card").remove();
    }
  }
}

function searchForWordResult(event) {
  if (event.key === "Enter") {
    event.preventDefault();
    fetch("/result.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        url: `https://api.dictionaryapi.dev/api/v2/entries/en/${searchResult.value}`,
      }),
    }).then((response) => {
      if (!response.ok) {
        throw new Error("Network failed");
      }
      createResultCard(response.json());
    });
    searchResult.value = "";
    clearResult();
  }
}

searchResult.addEventListener("keypress", searchForWordResult, true);
