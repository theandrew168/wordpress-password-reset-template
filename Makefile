.POSIX:
.SUFFIXES:

default: build

.PHONY: build
build:
	zip -r password-reset-template.zip index.php

.PHONY: clean
clean:
	rm *.zip
