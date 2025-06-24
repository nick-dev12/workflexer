from setuptools import setup, find_packages

setup(
    name="workflexer-matching-api",
    version="2.0.0",
    packages=find_packages(),
    install_requires=[
        "fastapi",
        "uvicorn",
        "python-dotenv",
        "sentence-transformers",
        "numpy",
        "scikit-learn",
    ],
    author="WorkFlexer",
    description="API de matching pour WorkFlexer",
    python_requires=">=3.8",
) 