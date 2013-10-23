.SILENT:
.PHONY: build install install-client install-server

build:
#	nothing to do

install: install-client install-server

install-client:
	install -d debian/gatherip/etc/NetworkManager/dispatcher.d
	install -m 0544 client/99gatherip debian/gatherip/etc/NetworkManager/dispatcher.d/
	install -d debian/gatherip/etc/default
	install -m 0444 client/defaults debian/gatherip/etc/default/gatherip

install-server:
	install -d debian/gatherip-server/usr/share/gatherip-server
	install -m 0444 server/* debian/gatherip-server/usr/share/gatherip-server/
