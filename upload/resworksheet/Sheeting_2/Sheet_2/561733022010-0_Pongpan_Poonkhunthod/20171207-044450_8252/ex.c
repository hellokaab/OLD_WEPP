#include <time.h>
    #include <process.h>
    #include <io.h>
    #include <fcntl.h>
    #include <stdlib.h>
    #include <windows.h>
    #include<stdio.h>

                static void error(char *action)
                {
                fprintf(stderr, "Error %s: %d\n", action, GetLastError());
                exit(EXIT_FAILURE);
                }
                void loop1(void *param)
                {
                int i=0;
                for(i=0;i<5;i++)
                {
                Sleep(1000);
                }
                exit(0);}
                int main(){
            HANDLE loop_thread[1];
                loop_thread[0] = (HANDLE) _beginthread( loop1,0,NULL);
                 if (loop_thread[0] == INVALID_HANDLE_VALUE)
                    error("creating read thread");
                    clock_t begin, end;
                    double time_spent;
                    begin = clock();
	printf("Hello C");

end = clock();time_spent = (double)(end - begin) / CLOCKS_PER_SEC;printf("###%f",time_spent);exit(0);}
