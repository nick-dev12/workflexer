import spacy
import nltk
import subprocess
import sys

def install_spacy_model(model_name="fr_core_news_sm"):
    """
    Downloads and installs a spaCy model if it's not already installed.
    """
    try:
        print(f"Checking for spaCy model: {model_name}...")
        spacy.load(model_name)
        print(f"Model '{model_name}' is already installed.")
    except OSError:
        print(f"Model '{model_name}' not found. Downloading...")
        try:
            subprocess.check_call([sys.executable, "-m", "spacy", "download", model_name])
            print(f"Model '{model_name}' downloaded successfully.")
        except subprocess.CalledProcessError as e:
            print(f"Error downloading spaCy model {model_name}: {e}")
            print("Please try running 'python -m spacy download fr_core_news_sm' manually.")
            sys.exit(1)

def download_nltk_data():
    """
    Downloads required NLTK data if not already present.
    """
    try:
        print("Checking for NLTK 'punkt' tokenizer...")
        nltk.data.find('tokenizers/punkt')
        print("'punkt' is already downloaded.")
    except nltk.downloader.DownloadError:
        print("NLTK 'punkt' not found. Downloading...")
        nltk.download('punkt')

    try:
        print("Checking for NLTK 'stopwords'...")
        nltk.data.find('corpora/stopwords')
        print("'stopwords' are already downloaded.")
    except nltk.downloader.DownloadError:
        print("NLTK 'stopwords' not found. Downloading...")
        nltk.download('stopwords')

if __name__ == "__main__":
    print("--- Setting up NLP models ---")
    install_spacy_model()
    download_nltk_data()
    print("--- NLP model setup complete ---") 