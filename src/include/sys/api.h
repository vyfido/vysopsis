// 
//  Visopsys
//  Copyright (C) 1998-2005 J. Andrew McLaughlin
//  
//  This library is free software; you can redistribute it and/or modify it
//  under the terms of the GNU Lesser General Public License as published by
//  the Free Software Foundation; either version 2.1 of the License, or (at
//  your option) any later version.
//
//  This library is distributed in the hope that it will be useful, but
//  WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser
//  General Public License for more details.
//
//  You should have received a copy of the GNU Lesser General Public License
//  along with this library; if not, write to the Free Software Foundation,
//  Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
//
//  api.h
//

// This file describes all of the functions that are directly exported by
// the Visopsys kernel to the outside world.  All functions and their
// numbers are listed here, as well as macros needed to perform call-gate
// calls into the kernel.  Also, each exported kernel function is represented
// here in the form of a little inline function.

#if !defined(_API_H)

// This file should mostly never be included when we're compiling a kernel
// file (kernelApi.c is an exception)
#if defined(KERNEL)
#error "You cannot call the kernel API from within a kernel function"
#endif

#ifndef _X_
#define _X_
#endif

#include <time.h>
#include <sys/disk.h>
#include <sys/file.h>
#include <sys/image.h>
#include <sys/process.h>
#include <sys/lock.h>
#include <sys/variable.h>
#include <sys/stream.h>
#include <sys/window.h>

// Included in the Visopsys standard library to prevent API calls from
// within kernel code.
extern int visopsys_in_kernel;

// Text input/output functions.  All are in the 1000-1999 range.
#define _fnum_textGetConsoleInput                    1000
#define _fnum_textSetConsoleInput                    1001
#define _fnum_textGetConsoleOutput                   1002
#define _fnum_textSetConsoleOutput                   1003
#define _fnum_textGetCurrentInput                    1004
#define _fnum_textSetCurrentInput                    1005
#define _fnum_textGetCurrentOutput                   1006
#define _fnum_textSetCurrentOutput                   1007
#define _fnum_textGetForeground                      1008
#define _fnum_textSetForeground                      1009
#define _fnum_textGetBackground                      1010
#define _fnum_textSetBackground                      1011
#define _fnum_textPutc                               1012
#define _fnum_textPrint                              1013
#define _fnum_textPrintLine                          1014
#define _fnum_textNewline                            1015
#define _fnum_textBackSpace                          1016
#define _fnum_textTab                                1017
#define _fnum_textCursorUp                           1018
#define _fnum_textCursorDown                         1019
#define _fnum_ternelTextCursorLeft                   1020
#define _fnum_textCursorRight                        1021
#define _fnum_textGetNumColumns                      1022
#define _fnum_textGetNumRows                         1023
#define _fnum_textGetColumn                          1024
#define _fnum_textSetColumn                          1025
#define _fnum_textGetRow                             1026
#define _fnum_textSetRow                             1027
#define _fnum_textSetCursor                          1028
#define _fnum_textScreenClear                        1029
#define _fnum_textScreenSave                         1030
#define _fnum_textScreenRestore                      1031
#define _fnum_textInputStreamCount                   1032
#define _fnum_textInputCount                         1033
#define _fnum_textInputStreamGetc                    1034
#define _fnum_textInputGetc                          1035
#define _fnum_textInputStreamReadN                   1036
#define _fnum_textInputReadN                         1037
#define _fnum_textInputStreamReadAll                 1038
#define _fnum_textInputReadAll                       1039
#define _fnum_textInputStreamAppend                  1040
#define _fnum_textInputAppend                        1041
#define _fnum_textInputStreamAppendN                 1042
#define _fnum_textInputAppendN                       1043
#define _fnum_textInputStreamRemove                  1044
#define _fnum_textInputRemove                        1045
#define _fnum_textInputStreamRemoveN                 1046
#define _fnum_textInputRemoveN                       1047
#define _fnum_textInputStreamRemoveAll               1048
#define _fnum_textInputRemoveAll                     1049
#define _fnum_textInputStreamSetEcho                 1050
#define _fnum_textInputSetEcho                       1051

// Disk functions.  All are in the 2000-2999 range.
#define _fnum_diskReadPartitions                     2000
#define _fnum_diskSync                               2001
#define _fnum_diskGetBoot                            2002
#define _fnum_diskGetCount                           2003
#define _fnum_diskGetPhysicalCount                   2004
#define _fnum_diskGetInfo                            2005
#define _fnum_diskGetPhysicalInfo                    2006
#define _fnum_diskGetPartType                        2007
#define _fnum_diskGetPartTypes                       2008
#define _fnum_diskSetLockState                       2009
#define _fnum_diskSetDoorState                       2010
#define _fnum_diskReadSectors                        2011
#define _fnum_diskWriteSectors                       2012
#define _fnum_diskReadAbsoluteSectors                2013
#define _fnum_diskWriteAbsoluteSectors               2014

// Filesystem functions.  All are in the 3000-3999 range.
#define _fnum_filesystemFormat                       3000
#define _fnum_filesystemCheck                        3001
#define _fnum_filesystemDefragment                   3002
#define _fnum_filesystemMount                        3003
#define _fnum_filesystemUnmount                      3004
#define _fnum_filesystemGetFree                      3005
#define _fnum_filesystemGetBlockSize                 3006

// File functions.  All are in the 4000-4999 range.
#define _fnum_fileFixupPath                          4000
#define _fnum_fileSeparateLast                       4001
#define _fnum_fileGetDisk                            4002
#define _fnum_fileFirst                              4003
#define _fnum_fileNext                               4004
#define _fnum_fileFind                               4005
#define _fnum_fileOpen                               4006
#define _fnum_fileClose                              4007
#define _fnum_fileRead                               4008
#define _fnum_fileWrite                              4009
#define _fnum_fileDelete                             4010
#define _fnum_fileDeleteSecure                       4011
#define _fnum_fileMakeDir                            4012
#define _fnum_fileRemoveDir                          4013
#define _fnum_fileCopy                               4014
#define _fnum_fileCopyRecursive                      4015
#define _fnum_fileMove                               4016
#define _fnum_fileTimestamp                          4017
#define _fnum_fileGetTemp                            4018
#define _fnum_fileStreamOpen                         4019
#define _fnum_fileStreamSeek                         4020
#define _fnum_fileStreamRead                         4021
#define _fnum_fileStreamReadLine                     4022
#define _fnum_fileStreamWrite                        4023
#define _fnum_fileStreamWriteStr                     4024
#define _fnum_fileStreamWriteLine                    4025
#define _fnum_fileStreamFlush                        4026
#define _fnum_fileStreamClose                        4027

// Memory manager functions.  All are in the 5000-5999 range.
#define _fnum_memoryPrintUsage                       5000
#define _fnum_memoryGet                              5001
#define _fnum_memoryGetPhysical                      5002
#define _fnum_memoryRelease                          5003
#define _fnum_memoryReleaseAllByProcId               5004
#define _fnum_memoryChangeOwner                      5005

// Multitasker functions.  All are in the 6000-6999 range.
#define _fnum_multitaskerCreateProcess               6000
#define _fnum_multitaskerSpawn                       6001
#define _fnum_multitaskerGetCurrentProcessId         6002
#define _fnum_multitaskerGetProcess                  6003
#define _fnum_multitaskerGetProcessByName            6004
#define _fnum_multitaskerGetProcesses                6005
#define _fnum_multitaskerSetProcessState             6006
#define _fnum_multitaskerSetProcessPriority          6007
#define _fnum_multitaskerGetProcessPrivilege         6008
#define _fnum_multitaskerGetCurrentDirectory         6009
#define _fnum_multitaskerSetCurrentDirectory         6010
#define _fnum_multitaskerGetTextInput                6011
#define _fnum_multitaskerSetTextInput                6012
#define _fnum_multitaskerGetTextOutput               6013
#define _fnum_multitaskerSetTextOutput               6014
#define _fnum_multitaskerDuplicateIO                 6015
#define _fnum_multitaskerGetProcessorTime            6016
#define _fnum_multitaskerYield                       6017
#define _fnum_multitaskerWait                        6018
#define _fnum_multitaskerBlock                       6019
#define _fnum_multitaskerDetach                      6020
#define _fnum_multitaskerKillProcess                 6021
#define _fnum_multitaskerKillByName                  6022
#define _fnum_multitaskerTerminate                   6023
#define _fnum_multitaskerProcessIsAlive              6024

// Loader functions.  All are in the 7000-7999 range.
#define _fnum_loaderLoad                             7000
#define _fnum_loaderLoadProgram                      7001
#define _fnum_loaderExecProgram                      7002
#define _fnum_loaderLoadAndExec                      7003

// Real-time clock functions.  All are in the 8000-8999 range.
#define _fnum_rtcReadSeconds                         8000
#define _fnum_rtcReadMinutes                         8001
#define _fnum_rtcReadHours                           8002
#define _fnum_rtcDayOfWeek                           8003
#define _fnum_rtcReadDayOfMonth                      8004
#define _fnum_rtcReadMonth                           8005
#define _fnum_rtcReadYear                            8006
#define _fnum_rtcUptimeSeconds                       8007
#define _fnum_rtcDateTime                            8008

// Random number functions.  All are in the 9000-9999 range.
#define _fnum_randomUnformatted                      9000
#define _fnum_randomFormatted                        9001
#define _fnum_randomSeededUnformatted                9002
#define _fnum_randomSeededFormatted                  9003

// Environment functions.  All are in the 10000-10999 range.
#define _fnum_environmentGet                         10000
#define _fnum_environmentSet                         10001
#define _fnum_environmentUnset                       10002
#define _fnum_environmentDump                        10003

// Raw graphics drawing functions.  All are in the 11000-11999 range
#define _fnum_graphicsAreEnabled                     11000
#define _fnum_graphicGetModes                        11001
#define _fnum_graphicGetMode                         11002
#define _fnum_graphicSetMode                         11003
#define _fnum_graphicGetScreenWidth                  11004
#define _fnum_graphicGetScreenHeight                 11005
#define _fnum_graphicCalculateAreaBytes              11006
#define _fnum_graphicClearScreen                     11007
#define _fnum_graphicGetColor                        11008
#define _fnum_graphicSetColor                        11009
#define _fnum_graphicDrawPixel                       11010
#define _fnum_graphicDrawLine                        11011
#define _fnum_graphicDrawRect                        11012
#define _fnum_graphicDrawOval                        11013
#define _fnum_graphicDrawImage                       11014
#define _fnum_graphicGetImage                        11015
#define _fnum_graphicDrawText                        11016
#define _fnum_graphicCopyArea                        11017
#define _fnum_graphicClearArea                       11018
#define _fnum_graphicRenderBuffer                    11019

// Windowing system functions.  All are in the 12000-12999 range
#define _fnum_windowLogin                            12000
#define _fnum_windowLogout                           12001
#define _fnum_windowNew                              12002
#define _fnum_windowNewDialog                        12003
#define _fnum_windowDestroy                          12004
#define _fnum_windowUpdateBuffer                     12005
#define _fnum_windowSetTitle                         12006
#define _fnum_windowGetSize                          12007
#define _fnum_windowSetSize                          12008
#define _fnum_windowGetLocation                      12009
#define _fnum_windowSetLocation                      12010
// DEPRECATED _fnum_windowPack                       12011
#define _fnum_windowCenter                           12012
#define _fnum_windowSnapIcons                        12013
#define _fnum_windowSetHasBorder                     12014
#define _fnum_windowSetHasTitleBar                   12015
#define _fnum_windowSetMovable                       12016
#define _fnum_windowSetResizable                     12017
// DEPRECATED _fnum_windowSetPacked                  12018
#define _fnum_windowSetHasMinimizeButton             12019
#define _fnum_windowSetHasCloseButton                12020
#define _fnum_windowSetColors                        12021
#define _fnum_windowSetVisible                       12022
#define _fnum_windowSetMinimized                     12023 
#define _fnum_windowAddConsoleTextArea               12024
#define _fnum_windowRedrawArea                       12025
#define _fnum_windowProcessEvent                     12026
#define _fnum_windowComponentEventGet                12027
#define _fnum_windowTileBackground                   12028
#define _fnum_windowCenterBackground                 12029
#define _fnum_windowScreenShot                       12030
#define _fnum_windowSaveScreenShot                   12031
#define _fnum_windowSetTextOutput                    12032
#define _fnum_windowComponentSetVisible              12033
#define _fnum_windowComponentSetEnabled              12034
#define _fnum_windowComponentGetWidth                12035
#define _fnum_windowComponentSetWidth                12036
#define _fnum_windowComponentGetHeight               12037
#define _fnum_windowComponentSetHeight               12038
#define _fnum_windowComponentFocus                   12039
#define _fnum_windowComponentDraw                    12040
#define _fnum_windowComponentGetData                 12041
#define _fnum_windowComponentSetData                 12042
#define _fnum_windowComponentGetSelected             12043
#define _fnum_windowComponentSetSelected             12044
#define _fnum_windowNewButton                        12045
#define _fnum_windowNewCanvas                        12046
#define _fnum_windowNewCheckbox                      12047
#define _fnum_windowNewContainer                     12048
#define _fnum_windowNewIcon                          12049
#define _fnum_windowNewImage                         12050
#define _fnum_windowNewList                          12051
#define _fnum_windowNewListItem                      12052
#define _fnum_windowNewMenu                          12053
#define _fnum_windowNewMenuBar                       12054
#define _fnum_windowNewMenuItem                      12055
#define _fnum_windowNewPasswordField                 12056
#define _fnum_windowNewProgressBar                   12057
#define _fnum_windowNewRadioButton                   12058
#define _fnum_windowNewScrollBar                     12059
#define _fnum_windowNewTextArea                      12060
#define _fnum_windowNewTextField                     12061
#define _fnum_windowNewTextLabel                     12062

// User functions.  All are in the 13000-13999 range
#define _fnum_userAuthenticate                       13000
#define _fnum_userLogin                              13001
#define _fnum_userLogout                             13002
#define _fnum_userGetNames                           13003
#define _fnum_userAdd                                13004
#define _fnum_userDelete                             13005
#define _fnum_userSetPassword                        13006
#define _fnum_userGetPrivilege                       13007
#define _fnum_userGetPid                             13008
#define _fnum_userSetPid                             13009

// Miscellaneous functions.  All are in the 99000-99999 range
#define _fnum_fontGetDefault                         99000
#define _fnum_fontSetDefault                         99001
#define _fnum_fontLoad                               99002
#define _fnum_fontGetPrintedWidth                    99003
#define _fnum_imageLoadBmp                           99004
#define _fnum_imageSaveBmp                           99005
#define _fnum_shutdown                               99006
#define _fnum_version                                99007
#define _fnum_encryptMD5                             99008
#define _fnum_lockGet                                99009
#define _fnum_lockRelease                            99010
#define _fnum_lockVerify                             99011
#define _fnum_variableListCreate                     99012
#define _fnum_variableListGet                        99013
#define _fnum_variableListSet                        99014
#define _fnum_variableListUnset                      99015
#define _fnum_configurationReader                    99016
#define _fnum_configurationWriter                    99017
#define _fnum_keyboardGetMaps                        99018
#define _fnum_keyboardSetMap                         99019


// Utility macros for stack manipulation
#define stackPush(value) \
  __asm__ __volatile__ ("pushl %0 \n\t" : : "r" (value))
#define stackAdj(bytes) \
  __asm__ __volatile__ ("addl %0, %%esp \n\t" \
                        : : "r" (bytes) : "%esp")

// The generic calls for accessing the kernel API
#define sysCall(retCode)                                            \
  if (!visopsys_in_kernel)                                          \
    {                                                               \
      __asm__ __volatile__ ("lcall $0x003B,$0x00000000 \n\t"        \
                            "movl %%eax, %0 \n\t"                   \
                            : "=r" (retCode) : : "%eax", "memory"); \
    }                                                               \
  else                                                              \
    {                                                               \
      retCode = -1;                                                 \
    }

// These use the macros defined above to call the kernel with the
// appropriate number of arguments

static inline int sysCall_0(int fnum)
{
  // Do a syscall with NO parameters
  int status = 0;
  stackPush(fnum);
  stackPush(1);
  sysCall(status);
  stackAdj(8);
  return (status);
}


static inline int sysCall_1(int fnum, void *arg1)
{
  // Do a syscall with 1 parameter
  int status = 0;
  stackPush(arg1);
  stackPush(fnum);
  stackPush(2);
  sysCall(status);
  stackAdj(12);
  return (status);
}


static inline int sysCall_2(int fnum, void *arg1, void *arg2)
{
  // Do a syscall with 2 parameters
  int status = 0;
  stackPush(arg2);
  stackPush(arg1);
  stackPush(fnum);
  stackPush(3);
  sysCall(status);
  stackAdj(16);
  return (status);
}


static inline int sysCall_3(int fnum, void *arg1, void *arg2, void *arg3)
{
  // Do a syscall with 3 parameters
  int status = 0;
  stackPush(arg3);
  stackPush(arg2);
  stackPush(arg1);
  stackPush(fnum);
  stackPush(4);
  sysCall(status);
  stackAdj(20);
  return (status);
}


static inline int sysCall_4(int fnum, void *arg1, void *arg2, void *arg3,
			    void *arg4)
{
  // Do a syscall with 4 parameters
  int status = 0;
  stackPush(arg4);
  stackPush(arg3);
  stackPush(arg2);
  stackPush(arg1);
  stackPush(fnum);
  stackPush(5);
  sysCall(status);
  stackAdj(24);
  return (status);
}


static inline int sysCall_5(int fnum, void *arg1, void *arg2, void *arg3,
			    void *arg4, void *arg5)
{
  // Do a syscall with 5 parameters
  int status = 0;
  stackPush(arg5);
  stackPush(arg4);
  stackPush(arg3);
  stackPush(arg2);
  stackPush(arg1);
  stackPush(fnum);
  stackPush(6);
  sysCall(status);
  stackAdj(28);
  return (status);
}


static inline int sysCall_6(int fnum, void *arg1, void *arg2, void *arg3,
			    void *arg4, void *arg5, void *arg6)
{
  // Do a syscall with 6 parameters
  int status = 0;
  stackPush(arg6);
  stackPush(arg5);
  stackPush(arg4);
  stackPush(arg3);
  stackPush(arg2);
  stackPush(arg1);
  stackPush(fnum);
  stackPush(7);
  sysCall(status);
  stackAdj(32);
  return (status);
}


static inline int sysCall_7(int fnum, void *arg1, void *arg2, void *arg3,
			    void *arg4, void *arg5, void *arg6, void *arg7)
{
  // Do a syscall with 7 parameters
  int status = 0;
  stackPush(arg7);
  stackPush(arg6);
  stackPush(arg5);
  stackPush(arg4);
  stackPush(arg3);
  stackPush(arg2);
  stackPush(arg1);
  stackPush(fnum);
  stackPush(8);
  sysCall(status);
  stackAdj(36);
  return (status);
}


static inline int sysCall_8(int fnum, void *arg1, void *arg2, void *arg3,
			    void *arg4, void *arg5, void *arg6, void *arg7,
			    void *arg8)
{
  // Do a syscall with 8 parameters
  int status = 0;
  stackPush(arg8);
  stackPush(arg7);
  stackPush(arg6);
  stackPush(arg5);
  stackPush(arg4);
  stackPush(arg3);
  stackPush(arg2);
  stackPush(arg1);
  stackPush(fnum);
  stackPush(9);
  sysCall(status);
  stackAdj(40);
  return (status);
}


static inline int sysCall_9(int fnum, void *arg1, void *arg2, void *arg3,
			    void *arg4, void *arg5, void *arg6, void *arg7,
			    void *arg8, void *arg9)
{
  // Do a syscall with 9 parameters
  int status = 0;
  stackPush(arg9);
  stackPush(arg8);
  stackPush(arg7);
  stackPush(arg6);
  stackPush(arg5);
  stackPush(arg4);
  stackPush(arg3);
  stackPush(arg2);
  stackPush(arg1);
  stackPush(fnum);
  stackPush(10);
  sysCall(status);
  stackAdj(44);
  return (status);
}


// These inline functions are used to call specific kernel functions.  
// There will be one of these for every API function.


//
// Text input/output functions
//

_X_ static inline objectKey textGetConsoleInput(void)
{
  // Proto: kernelTextInputStream *kernelTextGetConsoleInput(void);
  // Desc : Returns a reference to the console input stream.  This is where keyboard input goes by default.
  return ((objectKey) sysCall_0(_fnum_textGetConsoleInput));
}

_X_ static inline int textSetConsoleInput(objectKey newStream)
{
  // Proto: int kernelTextSetConsoleInput(kernelTextInputStream *);
  // Desc : Changes the console input stream.  GUI programs can use this function to redirect input to a text area or text field, for example.
  return (sysCall_1(_fnum_textSetConsoleInput, newStream));
}

_X_ static inline objectKey textGetConsoleOutput(void)
{
  // Proto: kernelTextOutputStream *kernelTextGetConsoleOutput(void);
  // Desc : Returns a reference to the console output stream.  This is where kernel logging output goes by default.
  return ((objectKey) sysCall_0(_fnum_textGetConsoleOutput));
}

_X_ static inline int textSetConsoleOutput(objectKey newStream)
{
  // Proto: int kernelTextSetConsoleOutput(kernelTextOutputStream *);
  // Desc : Changes the console output stream.  GUI programs can use this function to redirect output to a text area or text field, for example.
  return (sysCall_1(_fnum_textSetConsoleOutput, newStream));
}

_X_ static inline objectKey textGetCurrentInput(void)
{
  // Proto: kernelTextInputStream *kernelTextGetCurrentInput(void);
  // Desc : Returns a reference to the input stream of the current process.  This is where standard input (for example, from a getc() call) is received.
  return ((objectKey) sysCall_0(_fnum_textGetCurrentInput));
}

_X_ static inline int textSetCurrentInput(objectKey newStream)
{
  // Proto: int kernelTextSetCurrentInput(kernelTextInputStream *);
  // Desc : Changes the current input stream.  GUI programs can use this function to redirect input to a text area or text field, for example.
  return (sysCall_1(_fnum_textSetCurrentInput, newStream));
}

_X_ static inline objectKey textGetCurrentOutput(void)
{
  // Proto: kernelTextOutputStream *kernelTextGetCurrentOutput(void);
  // Desc : Returns a reference to the console output stream.
  return ((objectKey) sysCall_0(_fnum_textGetCurrentOutput));
}

_X_ static inline int textSetCurrentOutput(objectKey newStream)
{
  // Proto: int kernelTextSetCurrentOutput(kernelTextOutputStream *);
  // Desc : Changes the current output stream.  This is where standard output (for example, from a putc() call) goes.
  return (sysCall_1(_fnum_textSetCurrentOutput, newStream));
}

_X_ static inline int textGetForeground(void)
{
  // Proto: int kernelTextGetForeground(void);
  // Desc : Get the current foreground color as an int value.  Currently this is only applicable in text mode, and the color value should be treated as a PC built-in color value.  Here is a listing: 0=Black, 4=Red, 8=Dark gray, 12=Light red,  1=Blue, 5=Magenta, 9=Light blue, 13=Light magenta, 2=Green, 6=Brown, 10=Light green, 14=Yellow, 3=Cyan, 7=Light gray, 11=Light cyan, 15=White
  return (sysCall_0(_fnum_textGetForeground));
}

_X_ static inline int textSetForeground(int foreground)
{
  // Proto: int kernelTextSetForeground(int);
  // Desc : Set the current foreground color from an int value.  Currently this is only applicable in text mode, and the color value should be treated as a PC builtin color value.  See chart above.
  return (sysCall_1(_fnum_textSetForeground, (void *) foreground));
}

_X_ static inline int textGetBackground(void)
{
  // Proto: int kernelTextGetBackground(void);
  // Desc : Get the current background color as an int value.  Currently this is only applicable in text mode, and the color value should be treated as a PC builtin color value.  See chart above.
  return (sysCall_0(_fnum_textGetBackground));
}

_X_ static inline int textSetBackground(int background)
{
  // Proto: int kernelTextSetBackground(int);
  // Desc : Set the current foreground color from an int value.  Currently this is only applicable in text mode, and the color value should be treated as a PC builtin color value.  See chart above.
  return (sysCall_1(_fnum_textSetBackground, (void *) background));
}

_X_ static inline int textPutc(int ascii)
{
  // Proto: int kernelTextPutc(int);
  // Desc : Print a single character
  return (sysCall_1(_fnum_textPutc, (void*)ascii));
}

_X_ static inline int textPrint(const char *str)
{
  // Proto: int kernelTextPrint(const char *);
  // Desc : Print a string
  return (sysCall_1(_fnum_textPrint, (void *) str));
}

_X_ static inline int textPrintLine(const char *str)
{
  // Proto: int kernelTextPrintLine(const char *);
  // Desc : Print a string with a newline at the end
  return (sysCall_1(_fnum_textPrintLine, (void *) str));
}

_X_ static inline void textNewline(void)
{
  // Proto: void kernelTextNewline(void);
  // Desc : Print a newline
  sysCall_0(_fnum_textNewline);
}

_X_ static inline int textBackSpace(void)
{
  // Proto: void kernelTextBackSpace(void);
  // Desc : Backspace the cursor, deleting any character there
  return (sysCall_0(_fnum_textBackSpace));
}

_X_ static inline int textTab(void)
{
  // Proto: void kernelTextTab(void);
  // Desc : Print a tab
  return (sysCall_0(_fnum_textTab));
}

_X_ static inline int textCursorUp(void)
{
  // Proto: void kernelTextCursorUp(void);
  // Desc : Move the cursor up one row.  Doesn't affect any characters there.
  return (sysCall_0(_fnum_textCursorUp));
}

_X_ static inline int textCursorDown(void)
{
  // Proto: void kernelTextCursorDown(void);
  // Desc : Move the cursor down one row.  Doesn't affect any characters there.
  return (sysCall_0(_fnum_textCursorDown));
}

_X_ static inline int textCursorLeft(void)
{
  // Proto: void kernelTextCursorLeft(void);
  // Desc : Move the cursor left one column.  Doesn't affect any characters there.
  return (sysCall_0(_fnum_ternelTextCursorLeft));
}

_X_ static inline int textCursorRight(void)
{
  // Proto: void kernelTextCursorRight(void);
  // Desc : Move the cursor right one column.  Doesn't affect any characters there.
  return (sysCall_0(_fnum_textCursorRight));
}

_X_ static inline int textGetNumColumns(void)
{
  // Proto: int kernelTextGetNumColumns(void);
  // Desc : Get the total number of columns in the text area.
  return (sysCall_0(_fnum_textGetNumColumns));
}

_X_ static inline int textGetNumRows(void)
{
  // Proto: int kernelTextGetNumRows(void);
  // Desc : Get the total number of rows in the text area.
  return (sysCall_0(_fnum_textGetNumRows));
}

_X_ static inline int textGetColumn(void)
{
  // Proto: int kernelTextGetColumn(void);
  // Desc : Get the number of the current column.  Zero-based.
  return (sysCall_0(_fnum_textGetColumn));
}

_X_ static inline void textSetColumn(int c)
{
  // Proto: void kernelTextSetColumn(int);
  // Desc : Set the number of the current column.  Zero-based.  Doesn't affect any characters there.
  sysCall_1(_fnum_textSetColumn, (void *) c);
}

_X_ static inline int textGetRow(void)
{
  // Proto: int kernelTextGetRow(void);
  // Desc : Get the number of the current row.  Zero-based.
  return (sysCall_0(_fnum_textGetRow));
}

_X_ static inline void textSetRow(int r)
{
  // Proto: void kernelTextSetRow(int);
  // Desc : Set the number of the current row.  Zero-based.  Doesn't affect any characters there.
  sysCall_1(_fnum_textSetRow, (void *) r);
}

_X_ static inline void textSetCursor(int on)
{
  // Proto: void kernelTextSetCursor(int);
  // Desc : Turn the cursor on (1) or off (0)
  sysCall_1(_fnum_textSetCursor, (void *) on);
}

_X_ static inline int textScreenClear(void)
{
  // Proto: void kernelTextScreenClear(void);
  // Desc : Erase all characters in the text area and set the row and column to (0, 0)
  return (sysCall_0(_fnum_textScreenClear));
}

_X_ static inline int textScreenSave(void)
{
  // Proto: int kernelTextScreenSave(void);
  // Desc : Save the current screen in an internal buffer.  Use with the textScreenRestore function.
  return (sysCall_0(_fnum_textScreenSave));
}

_X_ static inline int textScreenRestore(void)
{
  // Proto: int kernelTextScreenRestore(void);
  // Desc : Restore the screen previously saved with the textScreenSave function
  return (sysCall_0(_fnum_textScreenRestore));
}

_X_ static inline int textInputStreamCount(objectKey strm)
{
  // Proto: int kernelTextInputStreamCount(kernelTextInputStream *);
  // Desc : Get the number of characters currently waiting in the specified input stream
  return (sysCall_1(_fnum_textInputStreamCount, strm));
}

_X_ static inline int textInputCount(void)
{
  // Proto: int kernelTextInputCount(void);
  // Desc : Get the number of characters currently waiting in the current input stream
  return (sysCall_0(_fnum_textInputCount));
}

_X_ static inline int textInputStreamGetc(objectKey strm, char *cp)
{
  // Proto: int kernelTextInputStreamGetc(kernelTextInputStream *, char *);
  // Desc : Get one character from the specified input stream (as an integer value).
  return (sysCall_2(_fnum_textInputStreamGetc, strm, cp));
}

_X_ static inline int textInputGetc(char *cp)
{
  // Proto: char kernelTextInputGetc(void);
  // Desc : Get one character from the default input stream (as an integer value).
  return (sysCall_1(_fnum_textInputGetc, cp));
}

_X_ static inline int textInputStreamReadN(objectKey strm, int num, char *buff)
{
  // Proto: int kernelTextInputStreamReadN(kernelTextInputStream *, int, char *);
  // Desc : Read up to 'num' characters from the specified input stream into 'buff'
  return (sysCall_3(_fnum_textInputStreamReadN, strm, (void *) num, buff));
}

_X_ static inline int textInputReadN(int num, char *buff)
{
  // Proto: int kernelTextInputReadN(int, char *);
  // Desc : Read up to 'num' characters from the default input stream into 'buff'
  return (sysCall_2(_fnum_textInputReadN, (void *)num, buff));
}

_X_ static inline int textInputStreamReadAll(objectKey strm, char *buff)
{
  // Proto: int kernelTextInputStreamReadAll(kernelTextInputStream *, char *);
  // Desc : Read all of the characters from the specified input stream into 'buff'
  return (sysCall_2(_fnum_textInputStreamReadAll, strm, buff));
}

_X_ static inline int textInputReadAll(char *buff)
{
  // Proto: int kernelTextInputReadAll(char *);
  // Desc : Read all of the characters from the default input stream into 'buff'
  return (sysCall_1(_fnum_textInputReadAll, buff));
}

_X_ static inline int textInputStreamAppend(objectKey strm, int ascii)
{
  // Proto: int kernelTextInputStreamAppend(kernelTextInputStream *, int);
  // Desc : Append a character (as an integer value) to the end of the specified input stream.
  return (sysCall_2(_fnum_textInputStreamAppend, strm, (void *) ascii));
}

_X_ static inline int textInputAppend(int ascii)
{
  // Proto: int kernelTextInputAppend(int);
  // Desc : Append a character (as an integer value) to the end of the default input stream.
  return (sysCall_1(_fnum_textInputAppend, (void *) ascii));
}

_X_ static inline int textInputStreamAppendN(objectKey strm, int num, char *str)
{
  // Proto: int kernelTextInputStreamAppendN(kernelTextInputStream *, int, char *);
  // Desc : Append 'num' characters to the end of the specified input stream from 'str'
  return (sysCall_3(_fnum_textInputStreamAppendN, strm, (void *) num, str));
}

_X_ static inline int textInputAppendN(int num, char *str)
{
  // Proto: int kernelTextInputAppendN(int, char *);
  // Desc : Append 'num' characters to the end of the default input stream from 'str'
  return (sysCall_2(_fnum_textInputAppendN, (void *) num, str));
}

_X_ static inline int textInputStreamRemove(objectKey strm)
{
  // Proto: int kernelTextInputStreamRemove(kernelTextInputStream *);
  // Desc : Remove one character from the start of the specified input stream.
  return (sysCall_1(_fnum_textInputStreamRemove, strm));
}

_X_ static inline int textInputRemove(void)
{
  // Proto: int kernelTextInputRemove(void);
  // Desc : Remove one character from the start of the default input stream.
  return (sysCall_0(_fnum_textInputRemove));
}

_X_ static inline int textInputStreamRemoveN(objectKey strm, int num)
{
  // Proto: int kernelTextInputStreamRemoveN(kernelTextInputStream *, int);
  // Desc : Remove 'num' characters from the start of the specified input stream.
  return (sysCall_2(_fnum_textInputStreamRemoveN, strm, (void *) num));
}

_X_ static inline int textInputRemoveN(int num)
{
  // Proto: int kernelTextInputRemoveN(int);
  // Desc : Remove 'num' characters from the start of the default input stream.
  return (sysCall_1(_fnum_textInputRemoveN, (void *) num));
}

_X_ static inline int textInputStreamRemoveAll(objectKey strm)
{
  // Proto: int kernelTextInputStreamRemoveAll(kernelTextInputStream *);
  // Desc : Empty the specified input stream.
  return (sysCall_1(_fnum_textInputStreamRemoveAll, strm));
}

_X_ static inline int textInputRemoveAll(void)
{
  // Proto: int kernelTextInputRemoveAll(void);
  // Desc : Empty the default input stream.
  return (sysCall_0(_fnum_textInputRemoveAll));
}

_X_ static inline void textInputStreamSetEcho(objectKey strm, int onOff)
{
  // Proto: void kernelTextInputStreamSetEcho(kernelTextInputStream *, int);
  // Desc : Set echo on (1) or off (0) for the specified input stream.  When on, any characters typed will be automatically printed to the text area.  When off, they won't.
  sysCall_2(_fnum_textInputStreamSetEcho, strm, (void *) onOff);
}

_X_ static inline void textInputSetEcho(int onOff)
{
  // Proto: void kernelTextInputSetEcho(int);
  // Desc : Set echo on (1) or off (0) for the default input stream.  When on, any characters typed will be automatically printed to the text area.  When off, they won't.
  sysCall_1(_fnum_textInputSetEcho, (void *) onOff);
}


// 
// Disk functions
//

_X_ static inline int diskReadPartitions(void)
{
  // Proto: int kernelDiskReadPartitions(void);
  // Desc : Tells the kernel to (re)read the disk partition tables.
  return (sysCall_0(_fnum_diskReadPartitions));
}

_X_ static inline int diskSync(void)
{
  // Proto: int kernelDiskSync(void);
  // Desc : Tells the kernel to synchronize all the disks, flushing any output.
  return (sysCall_0(_fnum_diskSync));
}

_X_ static inline int diskGetBoot(char *name)
{
  // Proto: int kernelDiskGetBoot(char *)
  // Desc : Get the disk name of the boot device.  Normally this will contain the root filesystem.
  return (sysCall_1(_fnum_diskGetBoot, name));
}

_X_ static inline int diskGetCount(void)
{
  // Proto: int kernelDiskGetCount(void);
  // Desc : Get the number of logical disk volumes recognized by the system
  return (sysCall_0(_fnum_diskGetCount));
}

_X_ static inline int diskGetPhysicalCount(void)
{
  // Proto: int kernelDiskGetPhysicalCount(void);
  // Desc : Get the number of physical disk devices recognized by the system
  return (sysCall_0(_fnum_diskGetPhysicalCount));
}

_X_ static inline int diskGetInfo(disk *d)
{
  // Proto: int kernelDiskGetInfo(disk *);
  // Desc : Get information about the logical disk volume named by the disk structure's 'name' field and fill in the remainder of the disk structure d.
  return (sysCall_1(_fnum_diskGetInfo, d));
}

_X_ static inline int diskGetPhysicalInfo(disk *d)
{
  // Proto: int kernelDiskGetPhysicalInfo(disk *);
  // Desc : Get information about the physical disk device named by the disk structure's 'name' field and fill in the remainder of the disk structure d.
  return (sysCall_1(_fnum_diskGetPhysicalInfo, d));
}

_X_ static inline int diskGetPartType(int code, partitionType *p)
{
  // Proto: int kernelDiskGetPartType(int, partitionType *);
  // Desc : Gets the partition type data for the corresponding code.  This function was added specifically by use by programs such as 'fdisk' to get descriptions of different types known to the kernel.
  return (sysCall_2(_fnum_diskGetPartType, (void *) code, p));
}

_X_ static inline partitionType *diskGetPartTypes(void)
{
  // Proto: partitionType *kernelDiskGetPartTypes(void);
  // Desc : Like diskGetPartType(), but returns a pointer to a list of all known types.
  return ((partitionType *) sysCall_0(_fnum_diskGetPartTypes));
}

_X_ static inline int diskSetLockState(const char *name, int state)
{
  // Proto: int kernelDiskSetLockState(const char *diskName, int state);
  // Desc : Set the locked state of the disk 'name' to either unlocked (0) or locked (1)
  return (sysCall_2(_fnum_diskSetLockState, (void *) name, (void *) state));
}

_X_ static inline int diskSetDoorState(const char *name, int state)
{
  // Proto: int kernelDiskSetDoorState(const char *, int);
  // Desc : Open (1) or close (0) the disk 'name'.  May require a unlocking the door first, see diskSetLockState().
  return (sysCall_2(_fnum_diskSetDoorState, (void *) name, (void *) state));
}

_X_ static inline int diskReadSectors(const char *name, unsigned sect, unsigned count, void *buf)
{
  // Proto: int kernelDiskReadSectors(const char *, unsigned, unsigned, void *)
  // Desc : Read 'count' sectors from disk 'name', starting at (zero-based) logical sector number 'sect'.  Put the data in memory area 'buf'.
  return (sysCall_4(_fnum_diskReadSectors, (void *) name, (void *) sect,
		    (void *) count, buf));
}

_X_ static inline int diskWriteSectors(const char *name, unsigned sect, unsigned count, void *buf)
{
  // Proto: int kernelDiskWriteSectors(const char *, unsigned, unsigned, void *)
  // Desc : Write 'count' sectors to disk 'name', starting at (zero-based) logical sector number 'sect'.  Get the data from memory area 'buf'.
  return (sysCall_4(_fnum_diskWriteSectors, (void *) name, (void *) sect,
		    (void *) count, buf));
}

_X_ static inline int diskReadAbsoluteSectors(const char *name, unsigned sect, unsigned count, void *buf)
{
  // Proto: int kernelDiskReadAbsoluteSectors(const char *, unsigned, unsigned, void *)
  // Desc : Read 'count' sectors from disk 'name', starting at (zero-based) absolute sector number 'sect'.  Put the data in memory area 'buf'.  This function requires supervisor privilege and is used to read outside the logical confines of a volume, such as a hard disk partition.  Not very useful unless you know what you're doing.
  return (sysCall_4(_fnum_diskReadAbsoluteSectors, (void *) name,
		    (void *) sect, (void *) count, buf));
}

_X_ static inline int diskWriteAbsoluteSectors(const char *name, unsigned sect, unsigned count, void *buf)
{
  // Proto: int kernelDiskWriteAbsoluteSectors(const char *, unsigned, unsigned, void *)
  // Desc : Write 'count' sectors to disk 'name', starting at (zero-based) absolute sector number 'sect'.  Get the data from memory area 'buf'.  This function requires supervisor privilege and is used to write outside the logical confines of a volume, such as a hard disk partition.  Don't use this unless you know what you're doing.
  return (sysCall_4(_fnum_diskWriteAbsoluteSectors, (void *) name,
		    (void *) sect, (void *) count, buf));
}


//
// Filesystem functions
//

_X_ static inline int filesystemFormat(const char *disk, const char *type, const char *label, int longFormat)
{
  // Proto: int kernelFilesystemFormat(const char *, const char *, const char *, int);
  // Desc : Format the logical volume 'disk', with a string 'type' representing the preferred filesystem type (for example, "fat", "fat16", "fat32, etc).  Label it with 'label'.  'longFormat' will do a sector-by-sector format, if supported.  It is optional for filesystem drivers to implement this function.
  return (sysCall_4(_fnum_filesystemFormat, (void *) disk, (void *) type,
		    (void *) label, (void *) longFormat));
}

_X_ static inline int filesystemCheck(const char *name, int force, int repair)
{
  // Proto: int kernelFilesystemCheck(const char *, int, int)
  // Desc : Check the filesystem on disk 'name'.  If 'force' is non-zero, the filesystem will be checked regardless of whether the filesystem driver thinks it needs to be.  If 'repair' is non-zero, the filesystem driver will attempt to repair any errors found.  If 'repair' is zero, a non-zero return value may indicate that errors were found.  If 'repair' is non-zero, a non-zero return value may indicate that errors were found but could not be fixed.  It is optional for filesystem drivers to implement this function.
  return (sysCall_3(_fnum_filesystemCheck, (void *) name, (void *) force,
		    (void *) repair));
}

_X_ static inline int filesystemDefragment(const char *name)
{
  // Proto: int kernelFilesystemDefragment(const char *)
  // Desc : Defragment the filesystem on disk 'name'.  It is optional for filesystem drivers to implement this function.
  return (sysCall_1(_fnum_filesystemCheck, (void *) name));
}

_X_ static inline int filesystemMount(const char *name, const char *mp)
{
  // Proto: int kernelFilesystemMount(const char *, const char *)
  // Desc : Mount the filesystem on disk 'name', using the mount point specified by the absolute pathname 'mp'.  Note that no file or directory called 'mp' should exist, as the mount function will expect to be able to create it.
  return (sysCall_2(_fnum_filesystemMount, (void *) name, (void *) mp));
}

_X_ static inline int filesystemUnmount(const char *mp)
{
  // Proto: int kernelFilesystemUnmount(const char *);
  // Desc : Unmount the filesystem mounted represented by the mount point 'fs'.
  return (sysCall_1(_fnum_filesystemUnmount, (void *)mp));
}

_X_ static inline int filesystemGetFree(const char *fs)
{
  // Proto: unsigned int kernelFilesystemGetFree(const char *);
  // Desc : Returns the amount of free space on the filesystem represented by the mount point 'fs'.
  return (sysCall_1(_fnum_filesystemGetFree, (void *) fs));
}

_X_ static inline unsigned int filesystemGetBlockSize(const char *fs)
{
  // Proto: unsigned int kernelFilesystemGetBlockSize(const char *);
  // Desc : Returns the block size (for example, 512 or 1024) of the filesystem represented by the mount point 'fs'.
  return (sysCall_1(_fnum_filesystemGetBlockSize, (void *) fs));
}


//
// File functions
//

_X_ static inline int fileFixupPath(const char *orig, char *new)
{
  // Proto: int kernelFileFixupPath(const char *, char *);
  // Desc : Take the absolute pathname in 'orig' and fix it up.  This means eliminating extra file separator characters (for example) and resolving links or '.' or '..' components in the pathname.
  return (sysCall_2(_fnum_fileFixupPath, (void *) orig, new));
}

_X_ static inline int fileSeparateLast(const char *origPath, char *pathName, char *fileName)
{
  // Proto: int kernelFileSeparateLast(const char *, char *, char *);
  // Desc : This function will take a combined pathname/filename string and separate the two.  The user will pass in the "combined" string along with two pre-allocated char arrays to hold the resulting separated elements.
  return (sysCall_3(_fnum_fileSeparateLast, (char *) origPath, pathName,
		    fileName));
}

_X_ static inline int fileGetDisk(const char *path, disk *d)
{
  // Proto: int kernelFileGetDisk(const char *, disk *);
  // Desc : Given the file name 'path', return the user space structure for the logical disk that the file resides on.
  return (sysCall_2(_fnum_fileGetDisk, (void *) path, (void *) d));
}

_X_ static inline int fileFirst(const char *path, file *f)
{
  // Proto: int kernelFileFirst(const char *, file *);
  // Desc : Get the first file from the directory referenced by 'path'.  Put the information in the file structure 'f'.
  return (sysCall_2(_fnum_fileFirst, (void *) path, (void *) f));
}

_X_ static inline int fileNext(const char *path, file *f)
{
  // Proto: int kernelFileNext(const char *, file *);
  // Desc : Get the next file from the directory referenced by 'path'.  'f' should be a file structure previously filled by a call to either fileFirst() or fileNext().
  return (sysCall_2(_fnum_fileNext, (void *) path, (void *) f));
}

_X_ static inline int fileFind(const char *name, file *f)
{
  // Proto: int kernelFileFind(const char *, kernelFile *);
  // Desc : Find the file referenced by 'name', and fill the file data structure 'f' with the results if successful.
  return (sysCall_2(_fnum_fileFind, (void *) name, (void *) f));
}

_X_ static inline int fileOpen(const char *name, int mode, file *f)
{
  // Proto: int kernelFileOpen(const char *, int, file *);
  // Desc : Open the file referenced by 'name' using the file open mode 'mode' (defined in <sys/file.h>).  Update the file data structure 'f' if successful.
  return (sysCall_3(_fnum_fileOpen, (void *) name, (void *) mode, 
		    (void *) f));
}

_X_ static inline int fileClose(file *f)
{
  // Proto: int kernelFileClose(const char *, file *);
  // Desc : Close the previously opened file 'f'.
  return (sysCall_1(_fnum_fileClose, (void *) f));
}

_X_ static inline int fileRead(file *f, unsigned int blocknum, unsigned int blocks, unsigned char *buff)
{
  // Proto: int kernelFileRead(file *, unsigned int, unsigned int, unsigned char *);
  // Desc : Read data from the previously opened file 'f'.  'f' should have been opened in a read or read/write mode.  Read 'blocks' blocks (see the filesystem functions for information about getting the block size of a given filesystem) and put them in buffer 'buff'.
  return (sysCall_4(_fnum_fileRead, (void *) f, (void *) blocknum, 
		    (void *) blocks, buff));
}

_X_ static inline int fileWrite(file *f, unsigned blocknum, unsigned blocks, unsigned char *buff)
{
  // Proto: int kernelFileWrite(file *, unsigned, unsigned, unsigned char *);
  // Desc : Write data to the previously opened file 'f'.  'f' should have been opened in a write or read/write mode.  Write 'blocks' blocks (see the filesystem functions for information about getting the block size of a given filesystem) from the buffer 'buff'.
  return (sysCall_4(_fnum_fileWrite, (void *) f, (void *) blocknum, 
		    (void *) blocks, buff));
}

_X_ static inline int fileDelete(const char *name)
{
  // Proto: int kernelFileDelete(const char *);
  // Desc : Delete the file referenced by the pathname 'name'.
  return (sysCall_1(_fnum_fileDelete, (void *) name));
}

_X_ static inline int fileDeleteSecure(const char *name)
{
  // Proto: int kernelFileDeleteSecure(const char *);
  // Desc : Securely delete the file referenced by the pathname 'name'.  If supported.
  return (sysCall_1(_fnum_fileDeleteSecure, (void *) name));
}

_X_ static inline int fileMakeDir(const char *name)
{
  // Proto: int kernelFileMakeDir(const char *);
  // Desc : Create a directory to be referenced by the pathname 'name'.
  return (sysCall_1(_fnum_fileMakeDir, (void *)name));
}

_X_ static inline int fileRemoveDir(const char *name)
{
  // Proto: int kernelFileRemoveDir(const char *);
  // Desc : Remove the directory referenced by the pathname 'name'.
  return (sysCall_1(_fnum_fileRemoveDir, (void *)name));
}

_X_ static inline int fileCopy(const char *src, const char *dest)
{
  // Proto: int kernelFileCopy(const char *, const char *);
  // Desc : Copy the file referenced by the pathname 'src' to the pathname 'dest'.  This will overwrite 'dest' if it already exists.
  return (sysCall_2(_fnum_fileCopy, (void *) src, (void *) dest));
}

_X_ static inline int fileCopyRecursive(const char *src, const char *dest)
{
  // Proto: int kernelFileCopyRecursive(const char *, const char *);
  // Desc : Recursively copy the file referenced by the pathname 'src' to the pathname 'dest'.  If 'src' is a regular file, the result will be the same as using the non-recursive call.  However if it is a directory, all contents of the directory and its subdirectories will be copied.  This will overwrite any files in the 'dest' tree if they already exist.
  return (sysCall_2(_fnum_fileCopyRecursive, (void *) src, (void *) dest));
}

_X_ static inline int fileMove(const char *src, const char *dest)
{
  // Proto: int kernelFileMove(const char *, const char *);
  // Desc : Move (rename) a file referenced by the pathname 'src' to the pathname 'dest'.
  return (sysCall_2(_fnum_fileMove, (void *) src, (void *) dest));
}

_X_ static inline int fileTimestamp(const char *name)
{
  // Proto: int kernelFileTimestamp(const char *);
  // Desc : Update the time stamp on the file referenced by the pathname 'name'
  return (sysCall_1(_fnum_fileTimestamp, (void *) name));
}

_X_ static inline int fileGetTemp(file *f)
{
  // Proto: int kernelFileGetTemp(void);
  // Desc : Create and open a temporary file in write mode.
  return (sysCall_1(_fnum_fileGetTemp, f));
}

_X_ static inline int fileStreamOpen(const char *name, int mode, fileStream *f)
{
  // Proto: int kernelFileStreamOpen(const char *, int, fileStream *);
  // Desc : Open the file referenced by the pathname 'name' for streaming operations, using the open mode 'mode' (defined in <sys/file.h>).  Fills the fileStream data structure 'f' with information needed for subsequent filestream operations.
  return (sysCall_3(_fnum_fileStreamOpen, (char *) name, (void *) mode,
		    (void *) f));
}

_X_ static inline int fileStreamSeek(fileStream *f, int offset)
{
  // Proto: int kernelFileStreamSeek(fileStream *, int);
  // Desc : Seek the filestream 'f' to the absolute position 'offset'
  return (sysCall_2(_fnum_fileStreamSeek, (void *) f, (void *) offset));
}

_X_ static inline int fileStreamRead(fileStream *f, int bytes, char *buff)
{
  // Proto: int kernelFileStreamRead(fileStream *, int, char *);
  // Desc : Read 'bytes' bytes from the filestream 'f' and put them into 'buff'.
  return (sysCall_3(_fnum_fileStreamRead, (void *) f, (void *) bytes, buff));
}

_X_ static inline int fileStreamReadLine(fileStream *f, int bytes, char *buff)
{
  // Proto: int kernelFileStreamReadLine(fileStream *, int, char *);
  // Desc : Read a complete line of text from the filestream 'f', and put up to 'bytes' characters into 'buff'
  return (sysCall_3(_fnum_fileStreamReadLine, (void *) f, (void *) bytes,
		    buff));
}

_X_ static inline int fileStreamWrite(fileStream *f, int bytes, char *buff)
{
  // Proto: int kernelFileStreamWrite(fileStream *, int, char *);
  // Desc : Write 'bytes' bytes from the buffer 'buff' to the filestream 'f'.
  return (sysCall_3(_fnum_fileStreamWrite, (void *) f, (void *) bytes, buff));
}

_X_ static inline int fileStreamWriteStr(fileStream *f, char *buff)
{
  // Proto: int kernelFileStreamWriteStr(fileStream *, char *);
  // Desc : Write the string in 'buff' to the filestream 'f'
  return (sysCall_2(_fnum_fileStreamWriteStr, (void *) f, buff));
}

_X_ static inline int fileStreamWriteLine(fileStream *f, char *buff)
{
  // Proto: int kernelFileStreamWriteLine(fileStream *, char *);
  // Desc : Write the string in 'buff' to the filestream 'f', and add a newline at the end
  return (sysCall_2(_fnum_fileStreamWriteLine, (void *) f, buff));
}

_X_ static inline int fileStreamFlush(fileStream *f)
{
  // Proto: int kernelFileStreamFlush(fileStream *);
  // Desc : Flush filestream 'f'.
  return (sysCall_1(_fnum_fileStreamFlush, (void *) f));
}

_X_ static inline int fileStreamClose(fileStream *f)
{
  // Proto: int kernelFileStreamClose(fileStream *);
  // Desc : [Flush and] close the filestream 'f'.
  return (sysCall_1(_fnum_fileStreamClose, (void *) f));
}


//
// Memory functions
//

_X_ static inline void memoryPrintUsage(int kernel)
{
  // Proto: void kernelMemoryPrintUsage(int);
  // Desc : Prints the current memory usage statistics to the current output stream.  If non-zero, the flag 'kernel' will show usage of kernel dynamic memory as well.
  sysCall_1(_fnum_memoryPrintUsage, (void *) kernel);
}

_X_ static inline void *memoryGet(unsigned size, const char *desc)
{
  // Proto: void *kernelMemoryGet(unsigned, const char *);
  // Desc : Return a pointer to a new block of memory of size 'size' and (optional) physical alignment 'align', adding the (optional) description 'desc'.  If no specific alignment is required, use '0'.  Memory allocated using this function is automatically cleared (like 'calloc').
  return ((void *) sysCall_2(_fnum_memoryGet, (void *) size, (void *) desc));
}

_X_ static inline void *memoryGetPhysical(unsigned size, unsigned align, const char *desc)
{
  // Proto: void *kernelMemoryGetPhysical(unsigned, unsigned, const char *);
  // Desc : Return a pointer to a new physical block of memory of size 'size' and (optional) physical alignment 'align', adding the (optional) description 'desc'.  If no specific alignment is required, use '0'.  Memory allocated using this function is NOT automatically cleared.  'Physical' refers to an actual physical memory address, and is not necessarily useful to external programs.
  return ((void *) sysCall_3(_fnum_memoryGetPhysical, (void *) size,
			     (void *) align, (void *) desc));
}

_X_ static inline int memoryRelease(void *p)
{
  // Proto: int kernelMemoryRelease(void *);
  // Desc : Release the memory block starting at the address 'p'.  Must have been previously allocated using the memoryRequestBlock() function.
  return (sysCall_1(_fnum_memoryRelease, p));
}

_X_ static inline int memoryReleaseAllByProcId(int pid)
{
  // Proto: int kernelMemoryReleaseAllByProcId(int);
  // Desc : Release all memory allocated to/by the process referenced by process ID 'pid'.  Only privileged functions can release memory owned by other processes.
  return (sysCall_1(_fnum_memoryReleaseAllByProcId, (void *) pid));
}

_X_ static inline int memoryChangeOwner(int opid, int npid, void *addr, void **naddr)
{
  // Proto: int kernelMemoryChangeOwner(int, int, void *, void **);
  // Desc : Change the ownership of an allocated block of memory beginning at address 'addr'.  'opid' is the process ID of the currently owning process, and 'npid' is the process ID of the intended new owner.  'naddr' is filled with the new address of the memory (since it changes address spaces in the process).  Note that only a privileged process can change memory ownership.
  return (sysCall_4(_fnum_memoryChangeOwner, (void *) opid, (void *) npid, 
		    addr, (void *) naddr));
}


//
// Multitasker functions
//

_X_ static inline int multitaskerCreateProcess(void *addr, unsigned int size, const char *name, int numargs, void *args)
{
  // Proto: int kernelMultitaskerCreateProcess(void *, unsigned int, const char *, int, void *);
  // Desc : Create a new process.  The code should have been loaded at the address 'addr' and be of size 'size'.  'name' will be the new process' name.  'numargs' and 'args' will be passed as the "int argc, char *argv[]) parameters of the new process.  If there are no arguments, these should be 0 and NULL, respectively.  If the value returned by the call is a positive integer, the call was successful and the value is the new process' process ID.  New processes are created and left in a stopped state, so if you want it to run you will need to set it to a running state ('ready', actually) using the function call multitaskerSetProcessState().
  return (sysCall_5(_fnum_multitaskerCreateProcess, addr, (void *) size, 
		   (void *) name, (void *) numargs, args));
}

_X_ static inline int multitaskerSpawn(void *addr, const char *name, int numargs, void *args)
{
  // Proto: int kernelMultitaskerSpawn(void *, const char *, int, void *);
  // Desc : Spawn a thread from the current process.  The starting point of the code (for example, a function address) should be specified as 'addr'.  'name' will be the new thread's name.  'numargs' and 'args' will be passed as the "int argc, char *argv[]) parameters of the new thread.  If there are no arguments, these should be 0 and NULL, respectively.  If the value returned by the call is a positive integer, the call was successful and the value is the new thread's process ID.  New threads are created and left in a stopped state, so if you want it to run you will need to set it to a running state ('ready', actually) using the function call multitaskerSetProcessState().
  return (sysCall_4(_fnum_multitaskerSpawn, addr, (void *) name, 
		    (void *) numargs, args));
}

_X_ static inline int multitaskerGetCurrentProcessId(void)
{
  // Proto: int kernelMultitaskerGetCurrentProcessId(void);
  // Desc : Returns the process ID of the calling program.
  return (sysCall_0(_fnum_multitaskerGetCurrentProcessId));
}

_X_ static inline int multitaskerGetProcess(int pid, process *proc)
{
  // Proto: int kernelMultitaskerGetProcess(int, process *);
  // Desc : Returns the process structure for the supplied process ID.
  return (sysCall_2(_fnum_multitaskerGetProcess, (void *) pid, proc));
}

_X_ static inline int multitaskerGetProcessByName(const char *name, process *proc)
{
  // Proto: int kernelMultitaskerGetProcessByName(const char *, process *);
  // Desc : Returns the process structure for the supplied process name
  return (sysCall_2(_fnum_multitaskerGetProcessByName, (void *) name, proc));
}

_X_ static inline int multitaskerGetProcesses(void *buffer, unsigned buffSize)
{
  // Proto: int kernelMultitaskerGetProcesses(void *, unsigned);
  // Desc : Fills 'buffer' with up to 'buffSize' bytes' worth of process structures, and returns the number of structures copied.
  return (sysCall_2(_fnum_multitaskerGetProcesses, buffer, (void *) buffSize));
}

_X_ static inline int multitaskerSetProcessState(int pid, int state)
{
  // Proto: int kernelMultitaskerSetProcessState(int, kernelProcessState);
  // Desc : Sets the state of the process referenced by process ID 'pid' to the new state 'state'.
  return (sysCall_2(_fnum_multitaskerSetProcessState, (void *) pid, 
		   (void *) state));
}


_X_ static inline int multitaskerProcessIsAlive(int pid)
{
  // Proto: int kernelMultitaskerProcessIsAlive(int);
  // Desc : Returns 1 if the process with the id 'pid' still exists and is in a 'runnable' (viable) state.  Returns 0 if the process does not exist or is in a 'finished' state.
  return (sysCall_1(_fnum_multitaskerProcessIsAlive, (void *) pid));
}

_X_ static inline int multitaskerSetProcessPriority(int pid, int priority)
{
  // Proto: int kernelMultitaskerSetProcessPriority(int, int);
  // Desc : Sets the priority of the process referenced by process ID 'pid' to 'priority'.
  return (sysCall_2(_fnum_multitaskerSetProcessPriority, (void *) pid, 
		   (void *)priority));
}

_X_ static inline int multitaskerGetProcessPrivilege(int pid)
{
  // Proto: kernelMultitaskerGetProcessPrivilege(int);
  // Desc : Gets the privilege level of the process referenced by process ID 'pid'.
  return (sysCall_1(_fnum_multitaskerGetProcessPrivilege, (void *) pid));
}

_X_ static inline int multitaskerGetCurrentDirectory(char *buff, int buffsz)
{
  // Proto: int kernelMultitaskerGetCurrentDirectory(char *, int);
  // Desc : Returns the absolute pathname of the calling process' current directory.  Puts the value in the buffer 'buff' which is of size 'buffsz'.
  return (sysCall_2(_fnum_multitaskerGetCurrentDirectory, buff, 
		   (void *) buffsz));
}

_X_ static inline int multitaskerSetCurrentDirectory(char *buff)
{
  // Proto: int kernelMultitaskerSetCurrentDirectory(char *);
  // Desc : Sets the current directory of the calling process to the absolute pathname 'buff'.
  return (sysCall_1(_fnum_multitaskerSetCurrentDirectory, buff));
}

_X_ static inline objectKey multitaskerGetTextInput(void)
{
  // Proto: kernelTextInputStream *kernelMultitaskerGetTextInput(void);
  // Desc : Get an object key to refer to the current text input stream of the calling process.
  return((objectKey) sysCall_0(_fnum_multitaskerGetTextInput));
}

_X_ static inline int multitaskerSetTextInput(int processId, objectKey key)
{
  // Proto: int kernelMultitaskerSetTextInput(int, kernelTextInputStream *);
  // Desc : Set the text input stream of the process referenced by process ID 'processId' to a text stream referenced by the object key 'key'.
  return (sysCall_2(_fnum_multitaskerSetTextInput, (void *) processId, key));
}

_X_ static inline objectKey multitaskerGetTextOutput(void)
{
  // Proto: kernelTextOutputStream *kernelMultitaskerGetTextOutput(void);
  // Desc : Get an object key to refer to the current text output stream of the calling process.
  return((objectKey) sysCall_0(_fnum_multitaskerGetTextOutput));
}

_X_ static inline int multitaskerSetTextOutput(int processId, objectKey key)
{
  // Proto: int kernelMultitaskerSetTextOutput(int, kernelTextOutputStream *);
  // Desc : Set the text output stream of the process referenced by process ID 'processId' to a text stream referenced by the object key 'key'.
  return (sysCall_2(_fnum_multitaskerSetTextOutput, (void *) processId, key));
}

_X_ static inline int multitaskerDuplicateIO(int pid1, int pid2, int clear)
{
  // Proto: int kernelMultitaskerDuplicateIO(int, int, int);
  // Desc : Set 'pid2' to use the same input and output streams as 'pid1', and if 'clear' is non-zero, clear any pending input or output.
  return (sysCall_3(_fnum_multitaskerDuplicateIO, (void *) pid1, (void *) pid2,
		    (void *) clear));
}

_X_ static inline int multitaskerGetProcessorTime(clock_t *clk)
{
  // Proto: int kernelMultitaskerGetProcessorTime(clock_t *);
  // Desc : Fill the clock_t structure with the amount of processor time consumed by the calling process.
  return (sysCall_1(_fnum_multitaskerGetProcessorTime, clk));
}

_X_ static inline void multitaskerYield(void)
{
  // Proto: void kernelMultitaskerYield(void);
  // Desc : Yield the remainder of the current processor timeslice back to the multitasker's scheduler.  It's nice to do this when you are waiting for some event, so that your process is not 'hungry' (i.e. hogging processor cycles unnecessarily).
  sysCall_0(_fnum_multitaskerYield);
}

_X_ static inline void multitaskerWait(unsigned int ticks)
{
  // Proto: void kernelMultitaskerWait(unsigned int);
  // Desc : Yield the remainder of the current processor timeslice back to the multitasker's scheduler, and wait at least 'ticks' timer ticks before running the calling process again.  On the PC, one second is approximately 20 system timer ticks.
  sysCall_1(_fnum_multitaskerWait, (void *) ticks);
}

_X_ static inline int multitaskerBlock(int pid)
{
  // Proto: int kernelMultitaskerBlock(int);
  // Desc : Yield the remainder of the current processor timeslice back to the multitasker's scheduler, and block on the process referenced by process ID 'pid'.  This means that the calling process will not run again until process 'pid' has terminated.  The return value of this function is the return value of process 'pid'.
  return (sysCall_1(_fnum_multitaskerBlock, (void *) pid));
}

_X_ static inline int multitaskerDetach(void)
{
  // Proto: int kernelMultitaskerDetach(void);
  // Desc : This allows a program to 'daemonize', detaching from the IO streams of its parent and, if applicable, the parent stops blocking.  Useful for a process that want to operate in the background, or that doesn't want to be killed if its parent is killed.
  return (sysCall_0(_fnum_multitaskerDetach));
}

_X_ static inline int multitaskerKillProcess(int pid, int force)
{
  // Proto: int kernelMultitaskerKillProcess(int);
  // Desc : Terminate the process referenced by process ID 'pid'.  If 'force' is non-zero, the multitasker will attempt to ignore any errors and dismantle the process with extreme prejudice.  The 'force' flag also has the necessary side effect of killing any child threads spawned by process 'pid'.  (Otherwise, 'pid' is left in a stopped state until its threads have terminated normally).
  return (sysCall_2(_fnum_multitaskerKillProcess, (void *) pid,
		    (void *) force));
}

_X_ static inline int multitaskerKillByName(const char *name, int force)
{
  // Proto: int kernelMultitaskerKillByName(const char *name, int force)
  // Desc : Like multitaskerKillProcess, except that it attempts to kill all instances of processes whose names match 'name'
  return (sysCall_2(_fnum_multitaskerKillByName, (void *) name,
		    (void *) force));
}

_X_ static inline int multitaskerTerminate(int code)
{
  // Proto: int kernelMultitaskerTerminate(int);
  // Desc : Terminate the calling process, returning the exit code 'code'
  return (sysCall_1(_fnum_multitaskerTerminate, (void *) code));
}


//
// Loader functions
//

_X_ static inline void *loaderLoad(const char *filename, file *theFile)
{
  // Proto: void *kernelLoaderLoad(const char *, file *);
  // Desc : Load a file referenced by the pathname 'filename', and fill the file data structure 'theFile' with the details.  The pointer returned points to the resulting file data.
  return ((void *) sysCall_2(_fnum_loaderLoad, (void *) filename,
			     (void *) theFile));
}

_X_ static inline int loaderLoadProgram(const char *userProgram, int privilege, int argc, char *argv[])
{
  // Proto: int kernelLoaderLoadProgram(const char *, int, int, char *[]);
  // Desc : Load the file referenced by the pathname 'userProgram' as a process with the privilege level 'privilege'.  Pass the arguments 'argc' and 'argv'.  If there are no arguments, these should be 0 and NULL, respectively.  If successful, the call's return value is the process ID of the new process.  The process is left in a stopped state and must be set to a running state explicitly using the multitasker function multitaskerSetProcessState() or the loader function loaderExecProgram().
  return (sysCall_4(_fnum_loaderLoadProgram, (void *) userProgram,
		    (void *) privilege, (void *) argc, argv));
}

_X_ static inline int loaderExecProgram(int processId, int block)
{
  // Proto: int kernelLoaderExecProgram(int, int);
  // Desc : Execute the process referenced by process ID 'processId'.  If 'block' is non-zero, the calling process will block until process 'pid' has terminated, and the return value of the call is the return value of process 'pid'.
  return (sysCall_2(_fnum_loaderExecProgram, (void *) processId,
		    (void *) block));
}

_X_ static inline int loaderLoadAndExec(const char *name, int privilege, int argc, char *argv[], int block)
{
  // Proto: kernelLoaderLoadAndExec(const char *, int, char *[], int);
  // Desc : This function is just for convenience, and is an amalgamation of the loader functions loaderLoadProgram() and  loaderExecProgram().
  return (sysCall_5(_fnum_loaderLoadAndExec, (void *) name,
		    (void *) privilege, (void *) argc, argv, (void *) block));
}


//
// Real-time clock functions
//

_X_ static inline int rtcReadSeconds(void)
{
  // Proto: int kernelRtcReadSeconds(void);
  // Desc : Get the current seconds value.
  return (sysCall_0(_fnum_rtcReadSeconds));
}

_X_ static inline int rtcReadMinutes(void)
{
  // Proto: int kernelRtcReadMinutes(void);
  // Desc : Get the current minutes value.
  return (sysCall_0(_fnum_rtcReadMinutes));
}

_X_ static inline int rtcReadHours(void)
{
  // Proto: int kernelRtcReadHours(void);
  // Desc : Get the current hours value.
  return (sysCall_0(_fnum_rtcReadHours));
}

_X_ static inline int rtcDayOfWeek(unsigned day, unsigned month, unsigned year)
{
  // Proto: int kernelRtcDayOfWeek(unsigned, unsigned, unsigned);
  // Desc : Get the current day of the week value.
  return (sysCall_3(_fnum_rtcDayOfWeek, (void *) day, (void *) month,
		    (void *) year));
}

_X_ static inline int rtcReadDayOfMonth(void)
{
  // Proto: int kernelRtcReadDayOfMonth(void);
  // Desc : Get the current day of the month value.
  return (sysCall_0(_fnum_rtcReadDayOfMonth));
}

_X_ static inline int rtcReadMonth(void)
{
  // Proto: int kernelRtcReadMonth(void);
  // Desc : Get the current month value.
  return (sysCall_0(_fnum_rtcReadMonth));
}

_X_ static inline int rtcReadYear(void)
{
  // Proto: int kernelRtcReadYear(void);
  // Desc : Get the current year value.
  return (sysCall_0(_fnum_rtcReadYear));
}

_X_ static inline unsigned int rtcUptimeSeconds(void)
{
  // Proto: unsigned int kernelRtcUptimeSeconds(void);
  // Desc : Get the number of seconds the system has been running.
  return (sysCall_0(_fnum_rtcUptimeSeconds));
}


_X_ static inline int rtcDateTime(struct tm *time)
{
  // Proto: int kernelRtcDateTime(struct tm *);
  // Desc : Get the current data and time as a tm data structure in 'time'.
  return (sysCall_1(_fnum_rtcDateTime, (void *) time));
}


//
// Random number functions
//

_X_ static inline unsigned int randomUnformatted(void)
{
  // Proto: unsigned int kernelRandomUnformatted(void);
  // Desc : Get an unformatted random unsigned number.  Just any unsigned number.
  return (sysCall_0(_fnum_randomUnformatted));
}

_X_ static inline unsigned int randomFormatted(unsigned int start, unsigned int end)
{
  // Proto: unsigned int kernelRandomFormatted(unsigned int, unsigned int);
  // Desc : Get a random unsigned number between the start value 'start' and the end value 'end', inclusive.
  return (sysCall_2(_fnum_randomFormatted, (void *) start, (void *) end));
}

_X_ static inline unsigned int randomSeededUnformatted(unsigned int seed)
{
  // Proto: unsigned int kernelRandomSeededUnformatted(unsigned int);
  // Desc : Get an unformatted random unsigned number, using the random seed 'seed' instead of the kernel's default random seed.
  return (sysCall_1(_fnum_randomSeededUnformatted, (void *) seed));
}

_X_ static inline unsigned int randomSeededFormatted(unsigned int seed, unsigned int start, unsigned int end)
{
  // Proto: unsigned int kernelRandomSeededFormatted(unsigned int, unsigned int, unsigned int);
  // Desc : Get a random unsigned number between the start value 'start' and the end value 'end', inclusive, using the random seed 'seed' instead of the kernel's default random seed.
  return (sysCall_3(_fnum_randomSeededFormatted, (void *) seed,
		    (void *) start, (void *) end));
}


//
// Environment functions
//

_X_ static inline int environmentGet(const char *var, char *buf, unsigned int bufsz)
{
  // Proto: int kernelEnvironmentGet(const char *, char *, unsigned int);
  // Desc : Get the value of the environment variable named 'var', and put it into the buffer 'buf' of size 'bufsz' if successful.
  return (sysCall_3(_fnum_environmentGet, (void *) var, buf, (void *) bufsz));
}

_X_ static inline int environmentSet(const char *var, const char *val)
{
  // Proto: int kernelEnvironmentSet(const char *, const char *);
  // Desc : Set the environment variable 'var' to the value 'val', overwriting any old value that might have been previously set.
  return (sysCall_2(_fnum_environmentSet, (void *) var, (void *) val));
}

_X_ static inline int environmentUnset(const char *var)
{
  // Proto: int kernelEnvironmentUnset(const char *);
  // Desc : Delete the environment variable 'var'.
  return (sysCall_1(_fnum_environmentUnset, (void *) var));
}

_X_ static inline void environmentDump(void)
{
  // Proto: void kernelEnvironmentDump(void);
  // Desc : Print a listing of all the currently set environment variables in the calling process' environment space to the current text output stream.
  sysCall_0(_fnum_environmentDump);
}


//
// Raw graphics functions
//

_X_ static inline int graphicsAreEnabled(void)
{
  // Proto: int kernelGraphicsAreEnabled(void);
  // Desc : Returns 1 if the kernel is operating in graphics mode.
  return (sysCall_0(_fnum_graphicsAreEnabled));
}

_X_ static inline int graphicGetModes(videoMode *buffer, int size)
{
  // Proto: int kernelGraphicGetModes(videoMode *, int);
  // Desc : Get up to 'size' bytes worth of videoMode structures in 'buffer' for the supported video modes of the current hardware.
  return (sysCall_2(_fnum_graphicGetModes, buffer, (void *) size));
}

_X_ static inline int graphicGetMode(videoMode *mode)
{
  // Proto: int kernelGraphicGetMode(videoMode *);
  // Desc : Get the current video mode in 'mode'
  return (sysCall_1(_fnum_graphicGetMode, mode));
}

_X_ static inline int graphicSetMode(videoMode *mode)
{
  // Proto: int kernelGraphicSetMode(videoMode *);
  // Desc : Set the video mode in 'mode'.  Generally this will require a reboot in order to take effect.
  return (sysCall_1(_fnum_graphicSetMode, mode));
}

_X_ static inline int graphicGetScreenWidth(void)
{
  // Proto: int kernelGraphicGetScreenWidth(void);
  // Desc : Returns the width of the graphics screen.
  return (sysCall_0(_fnum_graphicGetScreenWidth));
}

_X_ static inline int graphicGetScreenHeight(void)
{
  // Proto: int kernelGraphicGetScreenHeight(void);
  // Desc : Returns the height of the graphics screen.
  return (sysCall_0(_fnum_graphicGetScreenHeight));
}

_X_ static inline int graphicCalculateAreaBytes(int width, int height)
{
  // Proto: int kernelGraphicCalculateAreaBytes(int, int);
  // Desc : Returns the number of bytes required to allocate a graphic buffer of width 'width' and height 'height'.  This is a function of the screen resolution, etc.
  return (sysCall_2(_fnum_graphicCalculateAreaBytes, (void *) width,
		    (void *) height));
}

_X_ static inline int graphicClearScreen(color *background)
{
  // Proto: int kernelGraphicClearScreen(color *);
  // Desc : Clear the screen to the background color 'background'.
  return (sysCall_1(_fnum_graphicClearScreen, background));
}

_X_ static inline int graphicGetColor(const char *colorName, color *getColor)
{
  // Proto: int kernelGraphicGetColor(const char *, color *);
  // Desc : Get the system color 'colorName' and place its values in the color structure 'getColor'.  Examples of system color names include 'foreground', 'background', and 'desktop'.
  return (sysCall_2(_fnum_graphicGetColor, (void *) colorName, getColor));
}

_X_ static inline int graphicSetColor(const char *colorName, color *setColor)
{
  // Proto: int kernelGraphicSetColor(const char *, color *);
  // Desc : Set the system color 'colorName' to the values in the color structure 'getColor'.  Examples of system color names include 'foreground', 'background', and 'desktop'.
  return (sysCall_2(_fnum_graphicSetColor, (void *) colorName, setColor));
}

_X_ static inline int graphicDrawPixel(objectKey buffer, color *foreground, drawMode mode, int xCoord, int yCoord)
{
  // Proto: int kernelGraphicDrawPixel(kernelGraphicBuffer *, color *, drawMode, int, int);
  // Desc : Draw a single pixel into the graphic buffer 'buffer', using the color 'foreground', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the X coordinate 'xCoord' and the Y coordinate 'yCoord'.  If 'buffer' is NULL, draw directly onto the screen.
  return (sysCall_5(_fnum_graphicDrawPixel, buffer, foreground, (void *) mode,
		    (void *) xCoord, (void *) yCoord));
}

_X_ static inline int graphicDrawLine(objectKey buffer, color *foreground, drawMode mode, int startX, int startY, int endX, int endY)
{
  // Proto: int kernelGraphicDrawLine(kernelGraphicBuffer *, color *, drawMode, int, int, int, int);
  // Desc : Draw a line into the graphic buffer 'buffer', using the color 'foreground', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'startX', the starting Y coordinate 'startY', the ending X coordinate 'endX' and the ending Y coordinate 'endY'.  At the time of writing, only horizontal and vertical lines are supported by the linear framebuffer graphic driver.  If 'buffer' is NULL, draw directly onto the screen.
  return (sysCall_7(_fnum_graphicDrawLine, buffer, foreground, (void *) mode,
		    (void *) startX, (void *) startY, (void *) endX,
		    (void *) endY));
}

_X_ static inline int graphicDrawRect(objectKey buffer, color *foreground, drawMode mode, int xCoord, int yCoord, int width, int height, int thickness, int fill)
{
  // Proto: int kernelGraphicDrawRect(kernelGraphicBuffer *, color *, drawMode, int, int, int, int, int, int);
  // Desc : Draw a rectangle into the graphic buffer 'buffer', using the color 'foreground', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord', the width 'width', the height 'height', the line thickness 'thickness' and the fill value 'fill'.  Non-zero fill value means fill the rectangle.   If 'buffer' is NULL, draw directly onto the screen.
  return (sysCall_9(_fnum_graphicDrawRect, buffer, foreground, (void *) mode,
		    (void *) xCoord, (void *) yCoord, (void *) width,
		    (void *) height, (void *) thickness, (void *) fill));
}

_X_ static inline int graphicDrawOval(objectKey buffer, color *foreground, drawMode mode, int xCoord, int yCoord, int width, int height, int thickness, int fill)
{
  // Proto: int kernelGraphicDrawOval(kernelGraphicBuffer *, color *, drawMode, int, int, int, int, int, int);
  // Desc : Draw an oval (circle, whatever) into the graphic buffer 'buffer', using the color 'foreground', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord', the width 'width', the height 'height', the line thickness 'thickness' and the fill value 'fill'.  Non-zero fill value means fill the oval.   If 'buffer' is NULL, draw directly onto the screen.  Currently not supported by the linear framebuffer graphic driver.
  return (sysCall_9(_fnum_graphicDrawOval, buffer, foreground, (void *) mode,
		    (void *) xCoord, (void *) yCoord, (void *) width,
		    (void *) height, (void *) thickness, (void *) fill));
}

_X_ static inline int graphicDrawImage(objectKey buffer, image *drawImage, drawMode mode, int xCoord, int yCoord, int xOffset, int yOffset, int width, int height)
{
  // Proto: int kernelGraphicDrawImage(kernelGraphicBuffer *, image *, drawMode, int, int, int, int, int, int);
  // Desc : Draw the image 'drawImage' into the graphic buffer 'buffer', using the drawing mode 'mode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord' and the starting Y coordinate 'yCoord'.   The 'xOffset' and 'yOffset' parameters specify an offset into the image to start the drawing (0, 0 to draw the whole image).  Similarly the 'width' and 'height' parameters allow you to specify a portion of the image (0, 0 to draw the whole image -- minus any X or Y offsets from the previous parameters).  So, for example, to draw only the middle pixel of a 3x3 image, you would specify xOffset=1, yOffset=1, width=1, height=1.  If 'buffer' is NULL, draw directly onto the screen.
  return (sysCall_9(_fnum_graphicDrawImage, buffer, drawImage, (void *) mode,
		    (void *) xCoord, (void *) yCoord, (void *) xOffset,
		    (void *) yOffset, (void *) width, (void *) height));
}

_X_ static inline int graphicGetImage(objectKey buffer, image *getImage, int xCoord, int yCoord, int width, int height)
{
  // Proto: int kernelGraphicGetImage(kernelGraphicBuffer *, image *, int, int, int, int);
  // Desc : Grab a new image 'getImage' from the graphic buffer 'buffer', using the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord', the width 'width' and the height 'height'.   If 'buffer' is NULL, grab the image directly from the screen.
  return (sysCall_6(_fnum_graphicGetImage, buffer, getImage, (void *) xCoord,
		    (void *) yCoord, (void *) width, (void *) height));
}

_X_ static inline int graphicDrawText(objectKey buffer, color *foreground, color *background, objectKey font, const char *text, drawMode mode, int xCoord, int yCoord)
{
  // Proto: int kernelGraphicDrawText(kernelGraphicBuffer *, color *, color *, kernelAsciiFont *, const char *, drawMode, int, int);
  // Desc : Draw the text string 'text' into the graphic buffer 'buffer', using the colors 'foreground' and 'background', the font 'font', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord'.   If 'buffer' is NULL, draw directly onto the screen.  If 'font' is NULL, use the default font.
  return (sysCall_8(_fnum_graphicDrawText, buffer, foreground, background,
		    font, (void *) text, (void *) mode, (void *) xCoord,
		    (void *) yCoord));
}

_X_ static inline int graphicCopyArea(objectKey buffer, int xCoord1, int yCoord1, int width, int height, int xCoord2, int yCoord2)
{
  // Proto: int kernelGraphicCopyArea(kernelGraphicBuffer *, int, int, int, int, int, int);
  // Desc : Within the graphic buffer 'buffer', copy the area bounded by ('xCoord1', 'yCoord1'), width 'width' and height 'height' to the starting X coordinate 'xCoord2' and the starting Y coordinate 'yCoord2'.  If 'buffer' is NULL, copy directly to and from the screen.
  return (sysCall_7(_fnum_graphicCopyArea, buffer, (void *) xCoord1,
		    (void *) yCoord1, (void *) width, (void *) height,
		    (void *) xCoord2, (void *) yCoord2));
}

_X_ static inline int graphicClearArea(objectKey buffer, color *background, int xCoord, int yCoord, int width, int height)
{
  // Proto: int kernelGraphicClearArea(kernelGraphicBuffer *, color *, int, int, int, int);
  // Desc : Clear the area of the graphic buffer 'buffer' using the background color 'background', using the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord', the width 'width' and the height 'height'.  If 'buffer' is NULL, clear the area directly on the screen.
  return (sysCall_6(_fnum_graphicClearArea, buffer, background,
		    (void *) xCoord, (void *) yCoord, (void *) width,
		    (void *) height));
}

_X_ static inline int graphicRenderBuffer(objectKey buffer, int drawX, int drawY, int clipX, int clipY, int clipWidth, int clipHeight)
{
  // Proto: int kernelGraphicRenderBuffer(kernelGraphicBuffer *, int, int, int, int, int, int); 
  // Desc : Draw the clip of the buffer 'buffer' onto the screen.  Draw it on the screen at starting X coordinate 'drawX' and starting Y coordinate 'drawY'.  The buffer clip is bounded by the starting X coordinate 'clipX', the starting Y coordinate 'clipY', the width 'clipWidth' and the height 'clipHeight'.  It is not legal for 'buffer' to be NULL in this case.
  return (sysCall_7(_fnum_graphicRenderBuffer, buffer, (void *) drawX,
		    (void *) drawY, (void *) clipX, (void *) clipY,
		    (void *) clipWidth, (void *) clipHeight));
}


//
// Windowing system functions
//

_X_ static inline int windowLogin(const char *userName, const char *passwd)
{
  // Proto: kernelWindowLogin(const char *, const char *);
  // Desc : Log the user into the window environment with 'userName' and 'passwd'.  The return value is the PID of the window shell for this session.
  return (sysCall_2(_fnum_windowLogin, (void *) userName,
		    (void *) passwd));
}

_X_ static inline int windowLogout(void)
{
  // Proto: kernelWindowLogout(void);
  // Desc : Log the current user out of the windowing system.  This kills the window shell process returned by windowLogin() call.
  return (sysCall_0(_fnum_windowLogout));
}

_X_ static inline objectKey windowNew(int processId, const char *title)
{
  // Proto: kernelWindow *kernelWindowNew(int, const char *);
  // Desc : Create a new window, owned by the process 'processId', and with the title 'title'.  Returns an object key to reference the window, needed by most other window functions below (such as adding components to the window)
  return ((objectKey) sysCall_2(_fnum_windowNew, (void *) processId,
				(void *) title));
}

_X_ static inline objectKey windowNewDialog(objectKey parent, const char *title)
{
  // Proto: kernelWindow *kernelWindowNewDialog(kernelWindow *, const char *);
  // Desc : Create a dialog window to associate with the parent window 'parent', using the supplied title.  In the current implementation, dialog windows are modal, which is the main characteristic distinguishing them from regular windows.
  return ((objectKey) sysCall_2(_fnum_windowNewDialog, parent,
				(void *) title));
}

_X_ static inline int windowDestroy(objectKey window)
{
  // Proto: int kernelWindowDestroy(kernelWindow *);
  // Desc : Destroy the window referenced by the object key 'wndow'
  return (sysCall_1(_fnum_windowDestroy, window));
}

_X_ static inline int windowUpdateBuffer(void *buffer, int xCoord, int yCoord, int width, int height)
{
  // Proto: kernelWindowUpdateBuffer(kernelGraphicBuffer *, int, int, int, int);
  // Desc : Tells the windowing system to redraw the visible portions of the graphic buffer 'buffer', using the given clip coordinates/size.
  return (sysCall_5(_fnum_windowUpdateBuffer, buffer, (void *) xCoord,
					    (void *) xCoord, (void *) width,
					    (void *) height));
}

_X_ static inline int windowSetTitle(objectKey window, const char *title)
{
  // Proto: int kernelWindowSetTitle(kernelWindow *, const char *);
  // Desc : Set the new title of window 'window' to be 'title'.
  return (sysCall_2(_fnum_windowSetTitle, window, (void *) title));
}


_X_ static inline int windowGetSize(objectKey window, int *width, int *height)
{
  // Proto: int kernelWindowGetSize(kernelWindow *, int *, int *);
  // Desc : Get the size of the window 'window', and put the results in 'width' and 'height'.
  return (sysCall_3(_fnum_windowGetSize, window, width, height));
}

_X_ static inline int windowSetSize(objectKey window, int width, int height)
{
  // Proto: int kernelWindowSetSize(kernelWindow *, int, int);
  // Desc : Resize the window 'window' to the width 'width' and the height 'height'.
  return (sysCall_3(_fnum_windowSetSize, window, (void *) width,
		    (void *) height));
}

_X_ static inline int windowGetLocation(objectKey window, int *xCoord, int *yCoord)
{
  // Proto: int kernelWindowGetLocation(kernelWindow *, int *, int *);
  // Desc : Get the current screen location of the window 'window' and put it into the coordinate variables 'xCoord' and 'yCoord'.
  return (sysCall_3(_fnum_windowGetLocation, window, xCoord, yCoord));
}

_X_ static inline int windowSetLocation(objectKey window, int xCoord, int yCoord)
{
  // Proto: int kernelWindowSetLocation(kernelWindow *, int, int);
  // Desc : Set the screen location of the window 'window' using the coordinate variables 'xCoord' and 'yCoord'.
  return (sysCall_3(_fnum_windowSetLocation, window, (void *) xCoord,
		    (void *) yCoord));
}

_X_ static inline int windowPack(objectKey window)
{
  // Proto: int kernelWindowPack(kernelWindow *);
  // Desc : *DEPRECATED*
  return (0);
}

_X_ static inline int windowCenter(objectKey window)
{
  // Proto: int kernelWindowCenter(kernelWindow *);
  // Desc : Center 'window' on the screen.
  return (sysCall_1(_fnum_windowCenter, window));
}

_X_ static inline void windowSnapIcons(objectKey window)
{
  // Proto: void kernelWindowSnapIcons(kernelWindow *);
  // Desc : If 'window' has icon components inside it, this will snap them to a grid so that they fit inside the window.
  sysCall_1(_fnum_windowSnapIcons, window);
}

_X_ static inline int windowSetHasBorder(objectKey window, int trueFalse)
{
  // Proto: int kernelWindowSetHasBorder(kernelWindow *, int);
  // Desc : Tells the windowing system whether to draw a border around the window 'window'.  'trueFalse' being non-zero means draw a border.  Windows have borders by default.
  return (sysCall_2(_fnum_windowSetHasBorder, window, (void *) trueFalse));
}

_X_ static inline int windowSetHasTitleBar(objectKey window, int trueFalse)
{
  // Proto: int kernelWindowSetHasTitleBar(kernelWindow *, int);
  // Desc : Tells the windowing system whether to draw a title bar on the window 'window'.  'trueFalse' being non-zero means draw a title bar.  Windows have title bars by default.
  return (sysCall_2(_fnum_windowSetHasTitleBar, window, (void *) trueFalse));
}

_X_ static inline int windowSetMovable(objectKey window, int trueFalse)
{
  // Proto: int kernelWindowSetMovable(kernelWindow *, int);
  // Desc : Tells the windowing system whether the window 'window' should be movable by the user (i.e. clicking and dragging it).  'trueFalse' being non-zero means the window is movable.  Windows are movable by default.
  return (sysCall_2(_fnum_windowSetMovable, window, (void *) trueFalse));
}

_X_ static inline int windowSetResizable(objectKey window, int trueFalse)
{
  // Proto: int kernelWindowSetResizable(kernelWindow *, int);
  // Desc : Tells the windowing system whether to allow 'window' to be resized by the user.
  return (sysCall_2(_fnum_windowSetResizable, window, (void *) trueFalse));
}

_X_ static inline int windowSetPacked(objectKey window, int trueFalse)
{
  // Proto: int kernelWindowSetPacked(kernelWindow *, int);
  // Desc : *DEPRECATED*
  return (0);
}

_X_ static inline int windowSetHasMinimizeButton(objectKey window,
						 int trueFalse)
{
  // Proto: int kernelWindowSetHasMinimizeButton(kernelWindow *, int);
  // Desc : Tells the windowing system whether to draw a minimize button on the title bar of the window 'window'.  'trueFalse' being non-zero means draw a minimize button.  Windows have minimize buttons by default, as long as they have a title bar.  If there is no title bar, then this function has no effect.
  return (sysCall_2(_fnum_windowSetHasMinimizeButton, window,
		    (void *) trueFalse));
}  

_X_ static inline int windowSetHasCloseButton(objectKey window, int trueFalse)
{
  // Proto: int kernelWindowSetHasCloseButton(kernelWindow *, int);
  // Desc : Tells the windowing system whether to draw a close button on the title bar of the window 'window'.  'trueFalse' being non-zero means draw a close button.  Windows have close buttons by default, as long as they have a title bar.  If there is no title bar, then this function has no effect.
  return (sysCall_2(_fnum_windowSetHasCloseButton, window,
		    (void *) trueFalse));
}

_X_ static inline int windowSetColors(objectKey window, color *background)
{
  // Proto: int kernelWindowSetColors(kernelWindow *, color *);
  // Desc : Set the background color of 'window'.  If 'color' is NULL, use the default.
  return (sysCall_2(_fnum_windowSetColors, window, background));
}

_X_ static inline int windowSetVisible(objectKey window, int visible)
{
  // Proto: int kernelWindowSetVisible(kernelWindow *, int);
  // Desc : Tell the windowing system whether to make 'window' visible or not.  Non-zero 'visible' means make the window visible.  When windows are created, they are not visible by default so you can add components, do layout, set the size, etc.
  return (sysCall_2(_fnum_windowSetVisible, window, (void *) visible));
}

_X_ static inline void windowSetMinimized(objectKey window, int minimized)
{
  // Proto: void kernelWindowSetMinimized(kernelWindow *, int);
  // Desc : Tell the windowing system whether to make 'window' minimized or not.  Non-zero 'minimized' means make the window non-visible, but accessible via the task bar.  Zero 'minimized' means restore a minimized window to its normal, visible size.
  sysCall_2(_fnum_windowSetMinimized, window, (void *) minimized);
}

_X_ static inline int windowAddConsoleTextArea(objectKey window, componentParameters *params)
{
  // Proto: int kernelWindowAddConsoleTextArea(kernelWindow *, componentParameters *);
  // Desc : Add a console text area component to 'window' using the supplied componentParameters.  The console text area is where most kernel logging and error messages are sent, particularly at boot time.  Note that there is only one instance of the console text area, and thus it can only exist in one window at a time.  Destroying the window is one way to free the console area to be used in another window.
  return (sysCall_2(_fnum_windowAddConsoleTextArea, window, params));
}

_X_ static inline void windowRedrawArea(int xCoord, int yCoord, int width, int height)
{
  // Proto: void kernelWindowRedrawArea(int, int, int, int);
  // Desc : Tells the windowing system to redraw whatever is supposed to be in the screen area bounded by the supplied coordinates.  This might be useful if you were drawing non-window-based things (i.e., things without their own independent graphics buffer) directly onto the screen and you wanted to restore an area to its original contents.  For example, the mouse driver uses this method to erase the pointer from its previous position.
  sysCall_4(_fnum_windowRedrawArea, (void *) xCoord, (void *) yCoord,
	    (void *) width, (void *) height);
}

_X_ static inline void windowProcessEvent(objectKey event)
{
  // Proto: void kernelWindowProcessEvent(windowEvent *);
  // Desc : Creates a window event using the supplied event structure.  This function is most often used within the kernel, particularly in the mouse and keyboard functions, to signify clicks or key presses.  It can, however, be used by external programs to create 'artificial' events.  The windowEvent structure specifies the target component and event type.
  sysCall_1(_fnum_windowProcessEvent, event);
}

_X_ static inline int windowComponentEventGet(objectKey key, windowEvent *event)
{
  // Proto: int kernelWindowComponentEventGet(objectKey, windowEvent *);
  // Desc : Gets a pending window event, if any, applicable to component 'key', and puts the data into the windowEvent structure 'event'.  If an event was received, the function returns a positive, non-zero value (the actual value reflects the amount of raw data read from the component's event stream -- not particularly useful to an application).  If the return value is zero, no event was pending.
  return(sysCall_2(_fnum_windowComponentEventGet, key, event));
}

_X_ static inline int windowTileBackground(const char *file)
{
  // Proto: int kernelWindowTileBackground(const char *);
  // Desc : Load the image file specified by the pathname 'file', and if successful, tile the image on the background root window.
  return (sysCall_1(_fnum_windowTileBackground, (void *) file));
}

_X_ static inline int windowCenterBackground(const char *file)
{
  // Proto: int kernelWindowCenterBackground(const char *file);
  // Desc : Load the image file specified by the pathname 'file', and if successful, center the image on the background root window.
  return (sysCall_1(_fnum_windowCenterBackground, (void *) file));
}

_X_ static inline int windowScreenShot(image *saveImage)
{
  // Proto: int kernelWindowScreenShot(image *);
  // Desc : Get an image representation of the entire screen in the image data structure 'saveImage'.  Note that it is not necessary to allocate memory for the data pointer of the image structure beforehand, as this is done automatically.  You should, however, deallocate the data field of the image structure when you are finished with it.
  return (sysCall_1(_fnum_windowScreenShot, saveImage));
}

_X_ static inline int windowSaveScreenShot(const char *filename)
{
  // Proto: int kernelWindowSaveScreenShot(const char *);
  // Desc : Save a screenshot of the entire screen to the file specified by the pathname 'filename'.
  return (sysCall_1(_fnum_windowSaveScreenShot, (void *) filename));
}

_X_ static inline int windowSetTextOutput(objectKey key)
{
  // Proto: int kernelWindowSetTextOutput(kernelWindowComponent *);
  // Desc : Set the text output (and input) of the calling process to the object key of some window component, such as a TextArea or TextField component.  You'll need to use this if you want to output text to one of these components or receive input from one.
  return (sysCall_1(_fnum_windowSetTextOutput, key));
}

_X_ static inline int windowComponentSetVisible(objectKey component, int visible)
{
  // Proto: int kernelWindowComponentSetVisible(kernelWindowComponent *, int);
  // Desc : Set 'component' visible or non-visible.
  return (sysCall_2(_fnum_windowComponentSetVisible, component,
		    (void *) visible));
}

_X_ static inline int windowComponentSetEnabled(objectKey component, int enabled)
{
  // Proto: int kernelWindowComponentSetEnabled(kernelWindowComponent *, int);
  // Desc : Set 'component' enabled or non-enabled; non-enabled components appear greyed-out.
  return (sysCall_2(_fnum_windowComponentSetEnabled, component,
		    (void *) enabled));
}

_X_ static inline int windowComponentGetWidth(objectKey component)
{
  // Proto: int kernelWindowComponentGetWidth(kernelWindowComponent *);
  // Desc : Get the pixel width of the window component 'component'.
  return (sysCall_1(_fnum_windowComponentGetWidth, component));
}

_X_ static inline int windowComponentSetWidth(objectKey component, int width)
{
  // Proto: int kernelWindowComponentSetWidth(kernelWindowComponent *, int);
  // Desc : Set the pixel width of the window component 'component'
  return (sysCall_2(_fnum_windowComponentSetWidth, component, (void *) width));
}

_X_ static inline int windowComponentGetHeight(objectKey component)
{
  // Proto: int kernelWindowComponentGetHeight(kernelWindowComponent *);
  // Desc : Get the pixel height of the window component 'component'.
  return (sysCall_1(_fnum_windowComponentGetHeight, component));
}

_X_ static inline int windowComponentSetHeight(objectKey component, int height)
{
  // Proto: int kernelWindowComponentSetHeight(kernelWindowComponent *, int);
  // Desc : Set the pixel height of the window component 'component'.
  return (sysCall_2(_fnum_windowComponentSetHeight, component,
		    (void *) height));
}

_X_ static inline int windowComponentFocus(objectKey component)
{
  // Proto: int kernelWindowComponentFocus(kernelWindowComponent *);
  // Desc : Give window component 'component' the focus of its window.
  return (sysCall_1(_fnum_windowComponentFocus, component));
}

_X_ static inline int windowComponentDraw(objectKey component)
{
  // Proto: int kernelWindowComponentDraw(kernelWindowComponent *)
  // Desc : Calls the window component 'component' to redraw itself.
  return (sysCall_1(_fnum_windowComponentDraw, component));
}

_X_ static inline int windowComponentGetData(objectKey component, void *buffer, int size)
{
  // Proto: int kernelWindowComponentGetData(kernelWindowComponent *, void *, int);
  // Desc : This is a generic call to get data from the window component 'component', up to 'size' bytes, in the buffer 'buffer'.  The size and type of data that a given component will return is totally dependent upon the type and implementation of the component.
  return (sysCall_3(_fnum_windowComponentGetData, component, buffer,
		    (void *) size));
}

_X_ static inline int windowComponentSetData(objectKey component, void *buffer, int size)
{
  // Proto: int kernelWindowComponentSetData(kernelWindowComponent *, void *, int);
  // Desc : This is a generic call to set data in the window component 'component', up to 'size' bytes, in the buffer 'buffer'.  The size and type of data that a given component will use or accept is totally dependent upon the type and implementation of the component.
  return (sysCall_3(_fnum_windowComponentSetData, component, buffer,
		    (void *) size));
}

_X_ static inline int windowComponentGetSelected(objectKey component)
{
  // Proto: int kernelWindowComponentGetSelected(kernelWindowComponent *);
  // Desc : This is a call to get the 'selected' value of the window component 'component'.  The type of value returned depends upon the type of component; a list component, for example, will return the 0-based number of its selected item.  On the other hand, a boolean component such as a checkbox will return 1 if it is currently selected.
  return (sysCall_1(_fnum_windowComponentGetSelected, component));
}


_X_ static inline int windowComponentSetSelected(objectKey component, int selected)
{
  // Proto: int kernelWindowComponentSetSelected(kernelWindowComponent *, int);
  // Desc : This is a call to set the 'selected' value of the window component 'component'.  The type of value accepted depends upon the type of component; a list component, for example, will use the 0-based number to select one of its items.  On the other hand, a boolean component such as a checkbox will clear itself if 'selected' is 0, and set itself otherwise.
  return (sysCall_2(_fnum_windowComponentSetSelected, component,
		    (void *) selected));
}

_X_ static inline objectKey windowNewButton(objectKey parent, const char *label, image *buttonImage, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewButton(volatile void *, const char *, image *, componentParameters *);
  // Desc : Get a new button component to be placed inside the parent object 'parent', with the given component parameters, and with the (optional) label 'label', or the (optional) image 'buttonImage'.  Either 'label' or 'buttonImage' can be used, but not both.
  return ((objectKey) sysCall_4(_fnum_windowNewButton, parent, (void *) label,
				buttonImage, params));
}

_X_ static inline objectKey windowNewCanvas(objectKey parent, int width, int height, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewCanvas(volatile void *, int, int, componentParameters *);
  // Desc : Get a new canvas component, to be placed inside the parent object 'parent', using the supplied width and height, with the given component parameters.  Canvas components are areas which will allow drawing operations, for example to show line drawings or unique graphical elements.
  return ((objectKey) sysCall_4(_fnum_windowNewCanvas, parent,
				(void *) width, (void *) height, params));
}

_X_ static inline objectKey windowNewCheckbox(objectKey parent, const char *text, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewCheckbox(volatile void *, const char *, componentParameters *);
  // Desc : Get a new checkbox component, to be placed inside the parent object 'parent', using the accompanying text 'text', and with the given component parameters.
  return ((objectKey) sysCall_3(_fnum_windowNewCheckbox, parent, (void *) text,
				params));
}


_X_ static inline objectKey windowNewContainer(objectKey parent, const char *name, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewContainer(volatile void *, const char *, componentParameters *);
  // Desc : Get a new container component, to be placed inside the parent object 'parent', using the name 'name', and with the given component parameters.  Containers are useful for layout when a simple grid is not sufficient.  Each container has its own internal grid layout (for components it contains) and external grid parameters for placing it inside a window or another container.  Containers can be nested arbitrarily.  This allows limitless control over a complex window layout.
  return ((objectKey) sysCall_3(_fnum_windowNewContainer, parent,
				(void *) name, params));
}

_X_ static inline objectKey windowNewIcon(objectKey parent, image *iconImage, const char *label, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewIcon(volatile void *, image *, const char *, const char *, componentParameters *);
  // Desc : Get a new icon component to be placed inside the parent object 'parent', using the image data structure 'iconImage' and the label 'label', and with the given component parameters 'params'.
  return ((objectKey) sysCall_4(_fnum_windowNewIcon, parent, iconImage,
				(void *) label, params));
}

_X_ static inline objectKey windowNewImage(objectKey parent, image *baseImage, drawMode mode, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewImage(volatile void *, image *, drawMode, componentParameters *);
  // Desc : Get a new image component to be placed inside the parent object 'parent', using the image data structure 'baseImage', and with the given component parameters 'params'.
  return ((objectKey) sysCall_4(_fnum_windowNewImage, parent, baseImage,
				(void *) mode, params));
}

_X_ static inline objectKey windowNewList(objectKey parent, int rows, int columns, int multiple, char *items[], int numItems, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewList(volatile void *, int, int, int, const char *[], int, componentParameters *);
  // Desc : Get a new window list component to be placed inside the parent object 'parent', using the component parameters 'params'.  'rows' and 'columns' specify the size of the list and layout of the list items, 'multiple' allows multiple selections if non-zero, and 'numItems' specifies the number of strings in the array 'items' (which is an array of strings to represent the list items)
  return ((objectKey) sysCall_7(_fnum_windowNewList, parent, (void *) rows,
				(void *) columns, (void *) multiple, items,
				(void *) numItems, params));
}

_X_ static inline objectKey windowNewListItem(objectKey parent, const char *text, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewListItem(volatile void *, const char *, componentParameters *);
  // Desc : Get a new list item component to be placed inside the parent object 'parent', using the string 'text', and the component parameters 'params'.
  return ((objectKey) sysCall_3(_fnum_windowNewListItem, parent, (void *) text,
				params));
}

_X_ static inline objectKey windowNewMenu(objectKey parent, const char *name, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewMenu(volatile void *, const char *, componentParameters *);
  // Desc : Get a new menu component to be placed inside the parent object 'parent', using the name 'name' (which will be the header of the menu) and the component parameters 'params', and with the given component parameters 'params'.  A menu component is an instance of a container, typically contains menu item components, and is typically added to a menu bar component.
  return ((objectKey) sysCall_3(_fnum_windowNewMenu, parent, (void *) name,
				params));
}

_X_ static inline objectKey windowNewMenuBar(objectKey parent, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewMenuBar(volatile void *, componentParameters *);
  // Desc : Get a new menu bar component to be placed inside the parent object 'parent', using the component parameters 'params'.  A menu bar component is an instance of a container, and typically contains menu components.
  return ((objectKey) sysCall_2(_fnum_windowNewMenuBar, parent, params));
}

_X_ static inline objectKey windowNewMenuItem(objectKey parent, const char *text, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewMenuItem(volatile void *, const char *, componentParameters *);
  // Desc : Get a new menu item component to be placed inside the parent object 'parent', using the string 'text' and the component parameters 'params'.  A menu item  component is typically added to menu components, which are in turn added to menu bar components.
  return ((objectKey) sysCall_3(_fnum_windowNewMenuItem, parent, (void *) text,
				params));
}

_X_ static inline objectKey windowNewPasswordField(objectKey parent, int columns, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewPasswordField(volatile void *, int, componentParameters *);
  // Desc : Get a new password field component to be placed inside the parent object 'parent', using 'columns' columns and the component parameters 'params'.  A password field component is a special case of a text field component, and behaves the same way except that typed characters are shown as asterisks (*).
  return ((objectKey) sysCall_3(_fnum_windowNewPasswordField, parent,
				(void *) columns, params));
}

_X_ static inline objectKey windowNewProgressBar(objectKey parent, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewProgressBar(volatile void *, componentParameters *);
  // Desc : Get a new progress bar component to be placed inside the parent object 'parent', using the component parameters 'params'.  Use the windowComponentSetData() function to set the percentage of progress.
  return ((objectKey) sysCall_2(_fnum_windowNewProgressBar, parent, params));
}

_X_ static inline objectKey windowNewRadioButton(objectKey parent, int rows, int columns, char *items[], int numItems, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewRadioButton(volatile void *, int, int, const char **, int, componentParameters *);
  // Desc : Get a new radio button component to be placed inside the parent object 'parent', using the component parameters 'params'.  'rows' and 'columns' specify the size and layout of the items, and 'numItems' specifies the number of strings in the array 'items', which specifies the different radio button choices.  The windowComponentSetSelected() and windowComponentGetSelected() functions can be used to get and set the selected item (numbered from zero, in the order they were supplied in 'items').
  return ((objectKey) sysCall_6(_fnum_windowNewRadioButton, parent,
				(void *) rows, (void *) columns,
				items, (void *) numItems, params));
}

_X_ static inline objectKey windowNewScrollBar(objectKey parent, scrollBarType type, int width, int height, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewScrollBar(volatile void *, scrollBarType, int, int, componentParameters *);
  // Desc : Get a new scroll bar component to be placed inside the parent object 'parent', with the scroll bar type 'type', and the given component parameters 'params'.
  return ((objectKey) sysCall_5(_fnum_windowNewScrollBar, parent,
				(void *) type, (void *) width, (void *) height,
				params));
}

_X_ static inline objectKey windowNewTextArea(objectKey parent, int columns, int rows, int bufferLines, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewTextArea(volatile void *, int, int, int, componentParameters *);
  // Desc : Get a new text area component to be placed inside the parent object 'parent', with the given component parameters 'params'.  The 'columns' and 'rows' are the visible portion, and 'bufferLines' is the number of extra lines of scrollback memory.  If 'font' is NULL, the default font will be used.
  return ((objectKey) sysCall_5(_fnum_windowNewTextArea, parent,
	(void *) columns, (void *) rows, (void *) bufferLines, params));
}

_X_ static inline objectKey windowNewTextField(objectKey parent, int columns, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewTextField(volatile void *, int, componentParameters *);
  // Desc : Get a new text field component to be placed inside the parent object 'parent', using the number of columns 'columns' and with the given component parameters 'params'.  Text field components are essentially 1-line 'text area' components.  If the params 'font' is NULL, the default font will be used.
  return ((objectKey) sysCall_3(_fnum_windowNewTextField, parent,
				(void *) columns, params));
}

_X_ static inline objectKey windowNewTextLabel(objectKey parent, const char *text, componentParameters *params)
{
  // Proto: kernelWindowComponent *kernelWindowNewTextLabel(volatile void *, const char *, componentParameters *);
  // Desc : Get a new text labelComponent to be placed inside the parent object 'parent', with the given component parameters 'params', and using the text string 'text'.  If the params 'font' is NULL, the default font will be used.
  return ((objectKey) sysCall_3(_fnum_windowNewTextLabel, parent,
				(void *) text, params));
}


//
// User functions
//

_X_ static inline int userAuthenticate(const char *name, const char *password)
{
  // Proto: int kernelUserAuthenticate(const char *, const char *);
  // Desc : Given the user 'name', return 0 if 'password' is the correct password.
  return (sysCall_2(_fnum_userAuthenticate, (void *) name, (void *) password));
}

_X_ static inline int userLogin(const char *name, const char *password)
{
  // Proto: int kernelUserLogin(const char *, const char *);
  // Desc : Log the user 'name' into the system, using the password 'password'.  Calling this function requires supervisor privilege level.
  return (sysCall_2(_fnum_userLogin, (void *) name, (void *) password));
}

_X_ static inline int userLogout(const char *name)
{
  // Proto: int kernelUserLogout(const char *);
  // Desc : Log the user 'name' out of the system.  This can only be called by a process with supervisor privilege, or one running as the same user being logged out.
  return (sysCall_1(_fnum_userLogout, (void *) name));
}

_X_ static inline int userGetNames(char *buffer, unsigned bufferSize)
{
  // Proto: int kernelUserGetNames(char *, unsigned);
  // Desc : Fill the buffer 'buffer' with the names of all users, up to 'bufferSize' bytes.
  return (sysCall_2(_fnum_userGetNames, buffer, (void *) bufferSize));
}

_X_ static inline int userAdd(const char *name, const char *password)
{
  // Proto: int kernelUserAdd(const char *, const char *);
  // Desc : Add the user 'name' with the password 'password'
  return (sysCall_2(_fnum_userAdd, (void *) name, (void *) password));
}

_X_ static inline int userDelete(const char *name)
{
  // Proto: int kernelUserDelete(const char *);
  // Desc : Delete the user 'name'
  return (sysCall_1(_fnum_userDelete, (void *) name));
}

_X_ static inline int userSetPassword(const char *name, const char *oldPass, const char *newPass)
{
  // Proto: int kernelUserSetPassword(const char *, const char *, const char *);
  // Desc : Set the password of user 'name'.  If the calling program is not supervisor privilege, the correct old password must be supplied in 'oldPass'.  The new password is supplied in 'newPass'.
  return (sysCall_3(_fnum_userSetPassword, (void *) name, (void *) oldPass,
		    (void *) newPass));
}

_X_ static inline int userGetPrivilege(const char *name)
{
  // Proto: int kernelUserGetPrivilege(const char *);
  // Desc : Get the privilege level of the user represented by 'name'.
  return (sysCall_1(_fnum_userGetPrivilege, (void *) name));
}

_X_ static inline int userGetPid(void)
{
  // Proto: int kernelUserGetPid(void);
  // Desc : Get the process ID of the current user's 'login process'.
  return (sysCall_0(_fnum_userGetPid));
}

_X_ static inline int userSetPid(const char *name, int pid)
{
  // Proto: int kernelUserSetPid(const char *, int);
  // Desc : Set the login PID of user 'name' to 'pid'.  This is the process that gets killed when the user indicates that they want to logout.  In graphical mode this will typically be the PID of the window shell pid, and in text mode it will be the PID of the login VSH shell.
  return (sysCall_2(_fnum_userSetPid, (void *) name, (void *) pid));
}


//
// Miscellaneous functions
//

_X_ static inline int fontGetDefault(objectKey *pointer)
{
  // Proto: int kernelFontGetDefault(kernelAsciiFont **);
  // Desc : Get an object key in 'pointer' to refer to the current default font.
  return (sysCall_1(_fnum_fontGetDefault, pointer));
}

_X_ static inline int fontSetDefault(const char *name)
{
  // Proto: int kernelFontSetDefault(const char *);
  // Desc : Set the default font for the system to the font with the name 'name'.  The font must previously have been loaded by the system, for example using the fontLoad()  function.
  return (sysCall_1(_fnum_fontSetDefault, (void *) name));
}

_X_ static inline int fontLoad(const char* filename, const char *fontname, objectKey *pointer, int fixedWidth)
{
  // Proto: int kernelFontLoad(const char*, const char*, kernelAsciiFont **, int);
  // Desc : Load the font from the font file 'filename', give it the font name 'fontname' for future reference, and return an object key for the font in 'pointer' if successful.  The integer 'fixedWidth' argument should be non-zero if you want each character of the font to have uniform width (i.e. an 'i' character will be padded with empty space so that it takes up the same width as, for example, a 'W' character).
  return (sysCall_4(_fnum_fontLoad, (void *) filename, (void *) fontname,
		    pointer, (void *) fixedWidth));
}

_X_ static inline unsigned fontGetPrintedWidth(objectKey font, const char *string)
{
  // Proto: unsigned kernelFontGetPrintedWidth(kernelAsciiFont *, const char *);
  // Desc : Given the supplied string, return the screen width that the text will consume given the font 'font'.  Useful for placing text when using a variable-width font, but not very useful otherwise.
  return (sysCall_2(_fnum_fontGetPrintedWidth, font, (void *) string));
}

_X_ static inline int imageLoadBmp(const char *filename, image *loadImage)
{
  // Proto: int imageLoadBmp(const char *, image *);
  // Desc : Try to load the bitmap image file 'filename', and if successful, save the data in the image data structure 'loadImage'.
  return (sysCall_2(_fnum_imageLoadBmp, (void *) filename, loadImage));
}

_X_ static inline int imageSaveBmp(const char *filename, image *saveImage)
{
  // Proto: int imageSaveBmp(const char *, image *);
  // Desc : Save the image data structure 'saveImage' as a bitmap, to the file 'fileName'.
  return (sysCall_2(_fnum_imageSaveBmp, (void *) filename, saveImage));
}

_X_ static inline int shutdown(int reboot, int nice)
{
  // Proto: int kernelShutdown(kernelShutdownType, int);
  // Desc : Shut down the system.  If 'reboot' is non-zero, the system will reboot.  If 'nice' is zero, the shutdown will be orderly and will abort if serious errors are detected.  If 'nice' is non-zero, the system will go down like a kamikaze regardless of errors.
  return (sysCall_2(_fnum_shutdown, (void *) reboot, (void *) nice));
}

_X_ static inline const char *version(void)
{
  // Proto: const char *kernelVersion(void);
  // Desc : Get the kernel's version string.
  return ((const char *) sysCall_0(_fnum_version));
}

_X_ static inline int encryptMD5(const char *in, char *out)
{
  // Proto: int kernelEncryptMD5(const char *, char *);
  // Desc : Given the input string 'in', return the encrypted numerical message digest in the buffer 'out'.
  return (sysCall_2(_fnum_encryptMD5, (void *) in, out));
}

_X_ static inline int lockGet(lock *getLock)
{
  // Proto: int kernelLockGet(lock *);
  // Desc : Get an exclusive lock based on the lock structure 'getLock'.
  return (sysCall_1(_fnum_lockGet, (void *) getLock));
}

_X_ static inline int lockRelease(lock *relLock)
{
  // Proto: int kernelLockRelease(lock *);
  // Desc : Release a lock on the lock structure 'lock' previously obtained with a call to the lockGet() function.
  return (sysCall_1(_fnum_lockRelease, (void *) relLock));
}

_X_ static inline int lockVerify(lock *verLock)
{
  // Proto: int kernelLockVerify(lock *);
  // Desc : Verify that a lock on the lock structure 'verLock' is still valid.  This can be useful for retrying a lock attempt if a previous one failed; if the process that was previously holding the lock has failed, this will release the lock.
  return (sysCall_1(_fnum_lockVerify, (void *) verLock));
}

_X_ static inline variableList *variableListCreate(unsigned maxVar, unsigned size, const char *desc)
{
  // Proto: variableList *kernelVariableListCreate(unsigned, unsigned, const char *);
  // Desc : Get a new variable list structure with the maximum number of variables 'maxVar', the total data size 'size', and the description 'desc'.
  return ((variableList *) sysCall_3(_fnum_variableListCreate,
				     (void *) maxVar, (void *) size,
				     (void *) desc));
}
  
_X_ static inline int variableListGet(variableList *list, const char *var, char *buffer, unsigned buffSize)
{
  // Proto: int kernelVariableListGet(variableList *, const char *, char *, unsigned);
  // Desc : Get the value of the variable 'var' from the variable list 'list' in the buffer 'buffer', up to 'buffSize' bytes.
  return (sysCall_4(_fnum_variableListGet, list, (void *) var, buffer,
		    (void *) buffSize));
}

_X_ static inline int variableListSet(variableList *list, const char *var, const char *value)
{
  // Proto: int kernelVariableListSet(variableList *, const char *, const char *);
  // Desc : Set the value of the variable 'var' to the value 'value'.
  return (sysCall_3(_fnum_variableListSet, list, (void *) var,
		    (void *) value));
}

_X_ static inline int variableListUnset(variableList *list, const char *var)
{
  // Proto: int kernelVariableListUnset(variableList *, const char *);
  // Desc : Remove the variable 'var' from the variable list 'list'.
  return (sysCall_2(_fnum_variableListUnset, list, (void *) var));
}

_X_ static inline variableList *configurationReader(const char *fileName)
{
  // Proto: variableList *kernelConfigurationReader(const char *);
  // Desc : Read the contents of the configuration file 'fileName', and return the data in a variable list structure.  Configuration files are simple properties files, consisting of lines of the format "variable=value"
  return ((variableList *) sysCall_1(_fnum_configurationReader,
				     (void *) fileName));
}

_X_ static inline int configurationWriter(const char *fileName, variableList *list)
{
  // Proto: int kernelConfigurationWriter(const char *, variableList *);
  // Desc : Write the contents of the variable list 'list' to the configuration file 'fileName'.  Configuration files are simple properties files, consisting of lines of the format "variable=value".  If the configuration file already exists, the configuration writer will attempt to preserve comment lines (beginning with '#') and formatting whitespace.
  return (sysCall_2(_fnum_configurationWriter, (void *) fileName, list));
}

_X_ static inline int keyboardGetMaps(char *buffer, unsigned size)
{
  // Proto: int kernelKeyboardGetMaps(char *, unsigned);
  // Desc : Get a listing of the names of all available keyboard mappings.  The buffer is filled up to 'size' bytes with descriptive names, such as "English (UK)".  Each string is NULL-terminated, and the return value of the call is the number of strings copied.  The first string returned is the current map.
  return (sysCall_2(_fnum_keyboardGetMaps, buffer, (void *) size));
}

_X_ static inline int keyboardSetMap(const char *name)
{
  // Proto: int kernelKeyboardSetMap(const char *);
  // Desc : Set the keyboard mapping to the supplied 'name'.  The normal procedure would be to first call the keyboardGetMaps() function, get the list of supported mappings, and then call this function with one of those names.  Only a name returned by the keyboardGetMaps function is valid in this scenario.
  return (sysCall_1(_fnum_keyboardSetMap, (void *) name));
}

#define _API_H
#endif
