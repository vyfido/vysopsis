//
//  Visopsys
//  Copyright (C) 1998-2011 J. Andrew McLaughlin
// 
//  This program is free software; you can redistribute it and/or modify it
//  under the terms of the GNU General Public License as published by the Free
//  Software Foundation; either version 2 of the License, or (at your option)
//  any later version.
// 
//  This program is distributed in the hope that it will be useful, but
//  WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
//  or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
//  for more details.
//  
//  You should have received a copy of the GNU General Public License along
//  with this program; if not, write to the Free Software Foundation, Inc.,
//  59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
//
//  kernelPciDriver.h
//

// Based on an original version contributed by Jonas Zaddach: See the file
// contrib/jonas-pci/src/kernel/kernelBusPCI.h

#if !defined(_KERNELPCIDRIVER_H)

#define PCI_CONFIG_PORT              0x0CF8
#define PCI_DATA_PORT                0x0CFC

#define PCI_MAX_BUSES                255
#define PCI_MAX_DEVICES              32
#define PCI_MAX_FUNCTIONS            8
#define PCI_CONFIGHEADER_SIZE        64

#define PCI_INVALID_CLASSCODE        -1
#define PCI_INVALID_SUBCLASSCODE     -2

// PCI device info header types
#define PCI_HEADERTYPE_NORMAL        0
#define PCI_HEADERTYPE_BRIDGE        1
#define PCI_HEADERTYPE_CARDBUS       2
#define PCI_HEADERTYPE_MULTIFUNC     0x80

// PCI configuration register numbers.  Note that the registers are numbered
// according to their bit widths.  For example, the command register is
// a 16-bit word, so the register number is counted in words.  Base address
// registers are 32-bit dwords, so they're counted in dwords.
#define PCI_CONFREG_VENDORID_16      0
#define PCI_CONFREG_DEVICEID_16      1
#define PCI_CONFREG_COMMAND_16       2
#define PCI_CONFREG_STATUS_16        3
#define PCI_CONFREG_REVISIONID_8     8
#define PCI_CONFREG_PROGIF_8         9
#define PCI_CONFREG_SUBCLASSCODE_8   10
#define PCI_CONFREG_CLASSCODE_8      11
#define PCI_CONFREG_CACHELINESIZE_8  12
#define PCI_CONFREG_LATENCY_8        13
#define PCI_CONFREG_HEADERTYPE_8     14
#define PCI_CONFREG_BIST_8           15
#define PCI_CONFREG_CLASSREG_32      2
#define PCI_CONFREG_BASEADDRESS0_32  4
#define PCI_CONFREG_BASEADDRESS1_32  5
#define PCI_CONFREG_BASEADDRESS2_32  6
#define PCI_CONFREG_BASEADDRESS3_32  7
#define PCI_CONFREG_BASEADDRESS4_32  8
#define PCI_CONFREG_BASEADDRESS5_32  9
#define PCI_CONFREG_INTLINE_8        60

// PCI device command bits
#define PCI_COMMAND_FASTBACK2BACK    0x0200
#define PCI_COMMAND_SYSTEMERROR      0x0100
#define PCI_COMMAND_WAITCYCLE        0x0080
#define PCI_COMMAND_PARITYERROR      0x0040
#define PCI_COMMAND_VGAPALSNOOP      0x0020
#define PCI_COMMAND_MEMWRITEINV      0x0010
#define PCI_COMMAND_SPECIALCYCLE     0x0008
#define PCI_COMMAND_MASTERENABLE     0x0004
#define PCI_COMMAND_MEMORYENABLE     0x0002
#define PCI_COMMAND_IOENABLE         0x0001

// PCI device status bits
#define PCI_STATUS_DETPARTIYERROR    0x8000
#define PCI_STATUS_SIGSYSTEMERROR    0x4000
#define PCI_STATUS_RECVMASTERABRT    0x2000
#define PCI_STATUS_RECVTARGETABRT    0x1000
#define PCI_STATUS_SIGTARGETABRT     0x0800
#define PCI_STATUS_DEVSEL_SLOW       0x0400
#define PCI_STATUS_DEVSEL_MEDIUM     0x0200
#define PCI_STATUS_DEVSEL_FAST       0x0000
#define PCI_STATUS_DATAPARITY        0x0100
#define PCI_STATUS_FASTBACK2BACK     0x0080
#define PCI_STATUS_UDF               0x0040
#define PCI_STATUS_66MHZ             0x0020

// This structure is adapted from Ralf Brown's CPI configuration data dumper.
typedef union {
  struct {
    unsigned short vendorID;
    unsigned short deviceID;
    unsigned short commandReg;
    unsigned short statusReg;
    unsigned char revisionID;
    unsigned char progIF;
    unsigned char subClassCode;
    unsigned char classCode;
    unsigned char cachelineSize;
    unsigned char latency;
    unsigned char headerType;
    unsigned char BIST;
    union {
      struct {
	unsigned baseAddress[6];
	unsigned cardBusCIS;
	unsigned short subsystemVendorID;
	unsigned short subsystemDeviceID;
	unsigned expansionROM;
	unsigned char capPtr;
	unsigned char reserved1[3];
	unsigned reserved2[1];
	unsigned char interruptLine;
	unsigned char interruptPin;
	unsigned char minGrant;
	unsigned char maxLatency;
	unsigned deviceSpecific[48];
      } nonBridge;
      struct {
	unsigned baseAddress[2];
	unsigned char primaryBus;
	unsigned char secondaryBus;
	unsigned char subordinateBus;
	unsigned char secondaryLatency;
	unsigned char ioBaseLow;
	unsigned char ioLimitLow;
	unsigned short secondaryStatus;
	unsigned short memoryBaseLow;
	unsigned short memoryLimitLow;
	unsigned short prefetchBaseLow;
	unsigned short prefetchLimitLow;
	unsigned prefetchBaseHigh;
	unsigned prefetchLimitHigh;
	unsigned short ioBaseHigh;
	unsigned short ioLimitHigh;
	unsigned reserved2[1];
	unsigned expansionROM;
	unsigned char interruptLine;
	unsigned char interruptPin;
	unsigned short bridgeControl;
	unsigned deviceSpecific[48];
      } bridge;
      struct {
	unsigned exCaBase;
	unsigned char capPtr;
	unsigned char reserved05;
	unsigned short secondaryStatus;
	unsigned char pciBus;
	unsigned char bardBusBus;
	unsigned char subordinateBus;
	unsigned char latencyTimer;
	unsigned memoryBase0;
	unsigned memoryLimit0;
	unsigned memoryBase1;
	unsigned memoryLimit1;
	unsigned short ioBase0Low;
	unsigned short ioBase0High;
	unsigned short ioLimit0Low;
	unsigned short ioLimit0High;
	unsigned short ioBase1Low;
	unsigned short ioBase1High;
	unsigned short ioLimit1Low;
	unsigned short ioLimit1High;
	unsigned char interruptLine;
	unsigned char interruptPin;
	unsigned short bridgeControl;
	unsigned short subsystemVendorID;
	unsigned short subsystemDeviceID;
	unsigned legacyBaseAddr;
	unsigned cardbusReserved[14];
	unsigned vendorSpecific[32];
      } cardBus;
    };
  } device;
  unsigned header[64];

} __attribute__((packed)) pciDeviceInfo;

typedef volatile struct {
  int subClassCode;
  const char name[32];
  int systemClassCode;
  int systemSubClassCode;

} pciSubClass;

typedef volatile struct {
  int classCode;
  const char name[32];
  pciSubClass *subClasses;

} pciClass;

#define _KERNELPCIDRIVER_H
#endif
