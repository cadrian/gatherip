.SILENT:
.PHONY: build install

build:
#	nothing to do

install:
	install -d $(DESTDIR)/etc/NetworkManager/dispatcher.d
	install -m 0544 99gatherip $(DESTDIR)/etc/NetworkManager/dispatcher.d/
	install -d $(DESTDIR)/etc/default
	install -m 0444 defaults $(DESTDIR)/etc/default/gatherip
