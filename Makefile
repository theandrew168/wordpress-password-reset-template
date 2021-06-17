.POSIX:
.SUFFIXES:

default: build

.PHONY: build
build:
	zip -r password-reset-template.zip .

.PHONY: clean
clean:
	rm *.zip
